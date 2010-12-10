<?php

App::import('Helper', 'Burocrata.XmlTag');

class BuroBurocrataHelper extends XmlTagHelper
{
	public $helpers = array('Html', 'Form', 'Ajax', 'Js' => 'prototype', 'Burocrata.BuroOfficeBoy',
		'Typographer.*TypeBricklayer' => array(
			'name' => 'Bl',
			'receive_tools' => true
		)
	);

	public $modelAlias;
	public $modelPlugin;
	public $View;

	protected $_nestedInput = false;
	protected $_nestedOrder = 0;

	protected $_nestedForm = array();
	protected $_formMap = array();
	protected $_data = false;
	
	protected static $defaultSuperclass = array('buro');


/**
 * An alias method for the View::element method that enclosures the Jodel coventions
 *
 * @access public
 * @param string $modelClassName The model in format Plugin.Model
 * @param mixed $typeParams 
 * @return string The element rendered
 */
	public function insertForm($modelClassName, $typeParams = array())
	{
		$type= am(BuroBurocrataHelper::$defaultSuperclass, 'form', $typeParams);
		
		list($plugin, $model_alias) = pluginSplit($modelClassName);
		
		$View = &$this->_getView();
		return $View->element(Inflector::underscore($model_alias), compact('plugin', 'type'));
	}


/**
 * Begins a form field.
 *
 * @access public
 * @param  array $htmlAttributes
 * @param  array $options
 * @todo	Documentate better the input options
 * @return	string The HTML well formated
 */
	public function sinput($htmlAttributes = array(), $options = array())
	{
		$out = '';
		$defaults = array(
			'type' => 'text',
			'fieldName' => null,
			'label' => null,
			'options' => array()
		);
		$options = am($defaults, $options);
		$options['close_me'] = false;
		
		if($options['type'] == 'super_field')
		{
			$out .= $this->ssuperfield($htmlAttributes, $options);
		}
		else
		{
			$htmlAttributes = am(array('container' => array()), $htmlAttributes);
			$this->_nestedInput = false;
			if($options['type'] != 'hidden')
				$out .= $this->sinputcontainer($htmlAttributes['container'], $options);
			unset($htmlAttributes['container']);
			
			if(method_exists($this->Form, $options['type']))
			{
				if($options['type'] != 'hidden')
					$out .= $this->label(array(), $options, $options['label']);
				unset($options['label']);
				
				if(isset($options['instructions'])) {
					$out .= $this->instructions(array(),array(),$options['instructions']);
					unset($options['instructions']);
				}
				$inputOptions = am($htmlAttributes, $options['options'], array('label' => false, 'div' => false, 'type' => $options['type']));
				$out .= $this->Form->input($options['fieldName'], $inputOptions);
				
				$View = $this->_getView();
				
				$this->_addFormAttribute('inputs', $options);
			}
			else
			{
				$out .= $this->{Inflector::variable('input'.$options['type'])}($options);
			}
			
			if($options['type'] != 'hidden')
				$out .= $this->einputcontainer();
		}
		return $out;
	}


/**
 * End of form field. Ends all types of fields.
 *
 * @access	public
 * @return	string The HTML well formated
 */
	public function einput()
	{
		if($this->_nestedInput)
			return $this->esuperfield();
			
		$this->_nestedInput = --$this->_nestedOrder > 0;
		return $this->Bl->ediv();
	}


/**
 * Almost a copy of FormHelper::label() method
 *
 * @access public
 * @param  array $htmlAttributes
 * @param  array $options
 * @return	string The HTML well formated
 */
	public function label($htmlAttributes = array(), $options = array(), $text = null)
	{
		if(isset($options['fieldName'])) {
			$fieldName = $options['fieldName'];
		} else {
			$View =& $this->_getView();
			$fieldName = $View->entity();
			$fieldName = array_pop($fieldName);
		}
		$htmlDefaults = array(
			'for' => $this->domId($fieldName)
		);
		$htmlAttributes = am($htmlDefaults, $htmlAttributes);
		
		if ($text === null) {
			if (strpos($fieldName, '.') !== false) {
				$text = array_pop(explode('.', $fieldName));
			} else {
				$text = $fieldName;
			}
			if (substr($text, -3) == '_id') {
				$text = substr($text, 0, strlen($text) - 3);
			}
			$text = __(Inflector::humanize(Inflector::underscore($text)), true);
		}
		
		return $this->Bl->slabel($htmlAttributes) . $text . $this->Bl->elabel();
	}


/**
 * Error message
 *
 * @access public
 * @param  array $htmlAttributes
 * @param  array $options
 * @return	string The HTML well formated
 */
	public function error($htmlAttributes = array(), $options = array())
	{
		return $this->Form->error($options['fieldName']);
	}


/**
 * Just overloads the main tag method from XmlTag to avoid auto-closing divs.
 *
 * @access public
 * @param $htmlAttributes
 * @param $options
 * @return string The HTML well formated
 */
	public function form($htmlAttributes = array(), $options = array())
	{
		return $this->sform($htmlAttributes, $options) . $this->eform();
	}


/**
 * Starts a form.
 * 
 * ### Accepts the following options on second parameter:
 *
 * - `url` - URL where data will be posted. Defaults to /burocrata/buro_burocrata/save
 * - `model` - Model className, with plugin name when appropriate. Defaults to false
 * - `writeForm` - If true, attempts to write all form, using the conventional element. Defaults to false
 * - `data` Optional data that will fill out the form. Defaults to $this->data
 *
 * @access public
 * @param  array $htmlAttributes Controls the HTML parameters
 * @param  array $options 
 * @return string The HTML well formated
 */
	public function sform($htmlAttributes = array(), $options = array())
	{
		$View =& $this->_getView();
		$defaults = array(
			'url' => array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'save'),
			'writeForm' => false, 
			'model' => false,
			'callbacks' => array(),
			'data' => null
		);
		$options = am($defaults, $options);
		$options['close_me'] = false;
		
		$htmlDefaults = array(
			'id' => $domId = uniqid('frm')
		);
		$htmlAttributes = am($htmlDefaults, $htmlAttributes);
		$htmlAttributes = $this->addClass($htmlAttributes, 'buro_form');
		
		if($options['data'])
			$this->_data = $options['data'];
		elseif($View->data)
			$this->_data = $View->data;
		
		list($this->modelPlugin, $this->modelAlias) = pluginSplit($options['model']);
		
		$this->_addForm($htmlAttributes['id']);
		$this->_addFormAttribute('callbacks', $options['callbacks']);
		$this->_addFormAttribute('url', $options['url']);
		$this->_addFormAttribute('modelPlugin', $this->modelPlugin);
		$this->_addFormAttribute('modelAlias', $this->modelAlias);
		
		$this->Form->create($this->modelAlias, array('url' => $options['url']));
		
		$out = $this->Bl->sdiv($htmlAttributes);
		if($options['writeForm'] == true)
		{
			$elementOptions = array('type' => am(BuroBurocrataHelper::$defaultSuperclass, 'form'));
			if($this->modelPlugin)
				$elementOptions['plugin'] = $this->modelPlugin;
			if($this->_data)
				$elementOptions['data'] = $this->_data;
				
			$out .= $View->element(Inflector::underscore($this->modelAlias), $elementOptions);
			
			if(!$this->_readFormAttribute('submit'))
				$out .= $this->submit(array(), array('label' => __('Save', true)));
		}
		return $out;
	}


/**
 * 
 *
 * @access protected
 * @param string $id
 * @return void
 */
	protected function _addForm($id)
	{
		$this->_nestedForm[] = $id;
		$map =& $this->_formMap;
		foreach($this->_nestedForm as $form_id) {
			if(!isset($map[$form_id]))
				$map[$form_id]= array();
			if(!isset($map[$form_id]['subforms']))
				$map[$form_id] = array('subforms' => array(), 'inputs' => array());
			else
				$map =& $map[$form_id]['subforms'];
		}
	}


/**
 * Writes a attribute to current form
 *
 * @access protected
 * @param string $attribute
 * @param mixed $value
 * @return void
 */
	protected function _addFormAttribute($attribute, $value, $append = true)
	{
		$current_form = end($this->_nestedForm);
		$map =& $this->_formMap;
		foreach($this->_nestedForm as $form_id)
		{
			if(isset($map[$form_id])) {
				if($append && isset($map[$form_id][$attribute])) {
					$map[$form_id][$attribute] = am($map[$form_id][$attribute], array($value));
				} else {
					$map[$form_id][$attribute] = $value;
				}
			} else {
				$map =& $map[$form_id]['subforms'];
			}
		}
	}


/**
 * Read all attributes from the current form
 *
 * @access protected
 * @return array An array with attributes
 */
	protected function _readFormAttributes()
	{
		$current_form = end($this->_nestedForm);
		$map =& $this->_formMap;
		foreach($this->_nestedForm as $form_id)
		{
			if(isset($map[$form_id])) {
				return $map[$form_id];
			} elseif(!isset($map[$form_id]['subforms'])) {
				return null;
			} else {
				$map =& $map[$form_id]['subforms'];
			}
		}
	}


/**
 * Reads a attribute from the current form
 *
 * @access protected
 * @param string $attribute The name of attribute
 * @return mixed The attribute, if found, or null otherwise
 */
	protected function _readFormAttribute($attribute)
	{
		$attributes = $this->_readFormAttributes();
		if(isset($attributes[$attribute]))
			return $attributes[$attribute];
		return null;
	}


/**
 * Gets and caches an View object reference
 *
 * @access protected
 * @return object The View object reference
 */
	protected function _getView()
	{
		if(!$this->View)
			return $this->View = &ClassRegistry::getObject('view');
		
		return $this->View;
	}


/**
 * Generates a encoded string that will be decoded on the other side of request.
 * This string contain the model name and plugin and is hashed using the URL as key.
 *
 * @access public
 * @param string $url The URL where the form will be posted
 * @param string $modelPlugin Plugin name
 * @param string $modelAlias Model name
 * @return string The encoded string that will be decoded on the other side of request
 */
	public function security($url, $modelPlugin, $modelAlias)
	{
		$hash = Security::hash($this->url($url).$modelAlias.$modelPlugin);
		$secure = bin2hex(Security::cipher($modelPlugin.'.'.$modelAlias, $hash));
		return implode('|', array($modelPlugin, $modelAlias, $secure));
	}


/**
 * Render a HTTP param string that contain the security hash generated by security method
 *
 * @access public
 * @param string $url The URL where the form will be posted
 * @param string $modelPlugin Plugin name
 * @param string $modelAlias Model name
 * @return string A partial HTTP param string
 */
	public function securityParams($url, $modelPlugin, $modelAlias)
	{
		return 'data[request]='.$this->security($url, $modelPlugin, $modelAlias);
	}


/**
 * Ends a form and creates its javascript class
 *
 * @access public
 * @return string The HTML well formated
 */
	public function eform()
	{
		$View = $this->_getView();
		$out = '';
		
		$modelAlias = $this->_readFormAttribute('modelAlias');
		$modelPlugin = $this->_readFormAttribute('modelPlugin');
		$url = $this->_readFormAttribute('url');
		
		if(!empty($modelAlias))
			$out .= $this->Bl->sinput(array(
				'type' => 'hidden',
				'name' => 'data[request]',
				'value' => $this->security($url, $modelPlugin, $modelAlias),
				), array('close_me' => true)
			);
		$out .= $this->Bl->sinput(array(
			'type' => 'hidden',
			'name' => 'data[layout_scheme]',
			'value' => $View->viewVars['layout_scheme'],
			), array('close_me' => true)
		);
		$out .= $this->Bl->ediv();
		$out .= $this->Html->scriptBlock(
			$this->BuroOfficeBoy->newForm(
				end($this->_nestedForm),
				$this->_readFormAttributes()
			)
		);
		
		array_pop($this->_nestedForm);
		$this->Form->end();
		
		return $out;
	}


/**
 * Default submit button (actually is a simple button with javascript)
 * 
 * @access public
 * @param array $htmlAttributes
 * @param array $options
 */
	public function submit($htmlAttributes = array(), $options = array())
	{
		$htmlDefaults = array('class' => '', 'id' => uniqid('btn'));
		$htmlAttributes = $this->addClass(am($htmlDefaults, $htmlAttributes), 'submit');
		
		$defaults = array('label' => 'Submit');
		$options = am($defaults, $options);
		
		$this->_addFormAttribute('submit', $htmlAttributes['id']);
		
		return $this->Bl->button($htmlAttributes, $options, $options['label']);
	}





/**
 * Overloadable functions for layout modifications
 */





/**
 * Starts a input superfield thats aggregate others inputs
 *
 * @access public
 * @param  array $htmlAttributes
 * @param  array $options
 * @return string The HTML well formated
 */
	public function ssuperfield($htmlAttributes = array(), $options = array())
	{
		$this->_nestedOrder++;
		$this->_nestedInput = true;
		$htmlAttributes = $this->_mergeAttributes(array('class' => array('input','superfield')), $htmlAttributes);
		
		extract($options);
		
		$out = $this->Bl->sdiv($htmlAttributes);
		if(isset($label))
			$out .= $this->Bl->h6(array(),array('escape' => false), $label);
			
		if (isset($instructions))
			$out .= $this->Bl->p(array(), isset($options['escape']) && $options['escape'] ? array('escape' => $options['escape']) : array(), $instructions); 
		
		return "\n".$out;
	}


/**
 * Ends a input superfield thats aggregate others inputs
 *
 * @access public
 * @param  array $htmlAttributes
 * @param  array $options
 * @return string The HTML well formated
 */
	public function esuperfield()
	{
		$this->_nestedOrder--;
		return $this->Bl->ediv();
	}


/**
 * Starts a instruction enclosure
 *
 * @access public
 * @param  array $htmlAttributes
 * @param  array $options
 * @return string The HTML well formated
 */
	public function sinstructions($htmlAttributes = array(), $options = array())
	{
		// @todo add _mergeAttributes
		$htmlAttributes  = $this->_mergeAttributes(array('class' => array('instructions')), $htmlAttributes);
		
		return $this->Bl->sspan($htmlAttributes, $options);
	}


/**
 * Ends a instruction enclosure
 *
 * @access public
 * @param  array $htmlAttributes
 * @param  array $options
 * @return string The HTML well formated
 */
	public function einstructions()
	{
		return $this->Bl->espan();
	}


/**
 * Starts a input container
 *
 * @access public
 * @param  array $htmlAttributes
 * @param  array $options
 * @return string The HTML well formated
 */
	public function sinputcontainer($htmlAttributes = array(), $options = array())
	{
		$defaults = array();
		if($this->_nestedOrder > 0)
			$defaults['class'] = 'subinput'; //@todo Make the prefix automatic;
		else
			$defaults['class'] = 'input';
		
		$htmlAttributes = am($defaults, $htmlAttributes);
		
		if(isset($options['fieldName']))
		{
			$isFieldError = $this->Form->isFieldError($options['fieldName']);
			if($isFieldError)
				$htmlAttributes['class'] .= ' error'; //@todo Do not use strings with spaces for htmlAttributes, use arrays instead
		}
		
		$out = $this->Bl->sdiv($htmlAttributes,$options);
		return "\n".$out;
	}


/**
 * Ends a input container
 *
 * @access public
 */
	public function einputcontainer()
	{
		return $this->Bl->ediv();
	}


/**
 * Render an autocomplete input.
 *
 * ### The parameters are (must be passed in $options['options']):
 *
 * - `model` - Model name where the find will perform. No default, but needed only is url param not set.
 * - `url` - URL for post data (must return a JSON with error and content parameters). Defaults to BuroBurocrataController actions if mode parameter is set.
 * - `minChars` - Number of chars before start ajax call - Defaults to 2.
 * - `id_base` - An string that will be appended on every DOM ID. Defaults to uniqid().
 * - `callbacks` - An array with possible callbacks with Jodel Callbacks convention.
 *
 * @access public
 * @param array $options An array that defines all configurable parameters
 * @return string The HTML well formated
 * @todo Error handling
 */
	public function inputAutocomplete($options = array())
	{
		$View = $this->_getView();
		if(!isset($options['options']['model']) && !isset($options['options']['url']))
		{
			// error (`url` or `model` must be set)
			return false;
		}
		
		$defaults = array(
			'id_base' => uniqid(),
			'model' => false,
			'minChars' => 2,
			'url' => array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'autocomplete'),
			'callbacks' => array()
		);
		$autocomplete_options = am($defaults, $options['options']);
		$parameters = array();
		
		$parameters[] = 'data[layout_scheme]='.$View->viewVars['layout_scheme'];
		
		if($autocomplete_options['model'])
		{
			list($modelPlugin, $modelAlias) = pluginSplit($autocomplete_options['model']);
			$parameters[] = $this->securityParams($autocomplete_options['url'], $modelPlugin, $modelAlias);
		}
		
		if(!empty($modelAlias) && !isset($options['options']['url']) && (!isset($options['fieldName']) || empty($options['fieldName'])))
		{
			$class_name = $modelAlias;
			if(!empty($modelPlugin))
				$class_name = $modelPlugin . '.' . $class_name;
				
			$Model =& ClassRegistry::init($class_name);
			$options['fieldName'] = implode('.', array($modelAlias, $Model->displayField));
		}
		
		unset($autocomplete_options['model']);
		unset($options['options']);
		
		$autocomplete_options['parameters'] = implode('&', $parameters);
		
		
		$out = $this->input(array('class' => 'autocomplete', 'id' => 'input'.$autocomplete_options['id_base']),
			am($options, array(
				'type' => 'text',
				'fieldName' => $options['fieldName']
			))
		);
		$out .= $this->Bl->div(array('id' => 'div'.$autocomplete_options['id_base'], 'class' => 'autocomplete'), array('close_me' => false), ' ');
		$out .= $this->Html->scriptBlock($this->BuroOfficeBoy->autocomplete($autocomplete_options));
		
		return $out;
	}


/**
 * Construct a belongsTo form based on passed variable
 *
 * ### The options are:
 *
 * - `model` - The Alias used by related model (there is no default and MUST be passed).
 * - `type` - Type of form (can be 'autocomplete' or 'select'). Defaults to 'autocomplete'.
 * - `allow` - An array that contains the actions allowed - Defaults to array('create', 'modify', 'relate').
 * - `actions` - An array that defines all the URLs for CRUD actions Defaults to BuroBurocrataController actions.
 * - `callbacks` - An array with possible callbacks with Jodel Callbacks convention.
 *
 * @access public
 * @param array $options An array with non-defaults values
 * @return string The HTML well formated
 * @todo Error handling
 */
	public function inputBelongsTo($options = array())
	{
		$input_options = $options;
		$options = $options['options'];
		$defaults = array(
			'model' => false,
			'assocName' => false,
			'url' => array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'autocomplete'),
			'type' => 'autocomplete',
			'allow' => array('create', 'modify', 'relate')
		);
		$options = am($defaults, $options);
		extract($options);
		
		list($plugin, $model) = pluginSplit($model);
		if(!$assocName && !empty($model))
			$assocName = $model;
		
		// TODO: Trigger error `related model not set`
		if(!$assocName) return 'related model not set'; 
		unset($options['assocName']);
		unset($options['type']);
		
		// TODO: Trigger error `parent model not found`
		$parent_model = $this->modelAlias;
		$ParentModel =& ClassRegistry::init($this->modelPlugin . '.' . $parent_model);
		if(!$ParentModel) return 'parent model not found';
		
		// TODO: Trigger error `not a belongsTo related model`
		if(!isset($ParentModel->belongsTo[$assocName])) return 'not a belongsTo related model';
		$fieldName = implode('.', array($parent_model, $ParentModel->belongsTo[$assocName]['foreignKey']));
		
		switch($type)
		{
			case 'autocomplete':
				$model_class_name = $model;
				if($plugin)
					$model_class_name = $plugin . '.' . $model_class_name;
				
				$autocomplete_options = $input_options;
				$autocomplete_options['options']['model'] = $model_class_name;
				$autocomplete_options['options']['fieldName'] = $fieldName;
				$autocomplete_options['options'] = am($options, $autocomplete_options['options']);
				$input = $this->belongsToAutocomplete($autocomplete_options);
				
				break;
			case 'select': 
				$input = $this->belongsToSelect(array('id' => $domId));
				break;
				
			default:
				// TODO: trigger error `type not found`
				return false;
		}
		$out = $input;
		
		return $out;
	}


/**
 * Creates the autocomplete form for the belongsto input
 *
 * @access public
 * @params $options array
 * @return string The HTML well formated
 */
	public function belongsToAutocomplete($options = array())
	{
		extract($options['options']);
		unset($options['options']);
		$out = $out = $this->input(
			array('id' => $input_id = uniqid('npt')),
			array('type' => 'hidden', 'fieldName' => $fieldName)
		);
		
		list($plugin, $model_name) = pluginSplit($model);
		
		$input_id = uniqid('input');
		$update = uniqid('div');
		
		$url = array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'view');
		$params = array($this->securityParams($url, $plugin, $model_name));
		$params['data[id]'] = '@pair.id@';
		$callbacks = array('onSuccess' => array('contentUpdate' => $update));
		
		$autocomplete_options = array(
			'options' => array(
				'model' => $model,
				'callbacks' => array(
					'onSelect' => array(
						'js' => "if(pair.id > 0) $('$input_id').value = pair.id;",
						'ajax' => compact('callbacks', 'url', 'params'),
					)
				)
			)
		);
		if(isset($queryField))
			$options['fieldName'] = $queryField;
		
		$out = $this->inputAutocomplete(am($options, $autocomplete_options));
		$out .= $this->input(array('id' => $input_id), array('type' => 'hidden', 'fieldName' => $fieldName));
		$out .= $this->Bl->div(array('id' => $update), array('escape' => false), $this->error(array(), compact('fieldName')) . ' ');
		return $out;
	}
}


