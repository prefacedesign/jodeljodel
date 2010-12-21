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
	
	protected static $defaultSupertype = array('buro');
	protected static $defaultContainerClass = 'buro';
	protected static $defaultObjectClass = 'buro';


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
		$type= am(BuroBurocrataHelper::$defaultSupertype, 'form', $typeParams);
		
		list($plugin, $model_alias) = pluginSplit($modelClassName);
		
		$View = &$this->_getView();
		$plugin = Inflector::underscore($plugin);
		$element_name = Inflector::underscore($model_alias);
		
		return $View->element($element_name, compact('plugin', 'type'));
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
			$container = $htmlAttributes['container'];
			unset($htmlAttributes['container']);
			
			$this->_nestedInput = false;
			
			if($options['type'] != 'hidden' && $container !== false)
				$out .= $this->sinputcontainer($container, $options);
			
			if(method_exists($this->Form, $options['type']))
			{
				if($options['type'] != 'hidden')
					$out .= $this->label(array(), $options, $options['label']);
				unset($options['label']);
				
				if(isset($options['instructions'])) {
					$out .= $this->instructions(array(),array(),$options['instructions']);
					unset($options['instructions']);
				}
				$htmlAttributes = $this->addClass($htmlAttributes, BuroBurocrataHelper::$defaultObjectClass);
				$inputOptions = am($htmlAttributes, $options['options'], array('label' => false, 'div' => false, 'type' => $options['type']));
				$out .= $this->Form->input($options['fieldName'], $inputOptions);
				
				$View = $this->_getView();
				
				$this->_addFormAttribute('inputs', $options);
			}
			else
			{
				$out .= $this->{Inflector::variable('input'.$options['type'])}($options);
			}
			
			if($options['type'] != 'hidden' && $container !== false)
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
		$htmlAttributes = $this->addClass($htmlAttributes, BuroBurocrataHelper::$defaultObjectClass);
		
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
			'baseID' => uniqid(),
			'callbacks' => array(),
			'data' => null
		);
		$options = am($defaults, $options);
		$options['close_me'] = false;
		
		$htmlAttributes = $this->addClass($htmlAttributes, BuroBurocrataHelper::$defaultContainerClass);
		$htmlAttributes['id'] = 'frm' . $options['baseID'];
		
		if($options['data'])
			$this->_data = $options['data'];
		elseif($View->data)
			$this->_data = $View->data;
		
		list($this->modelPlugin, $this->modelAlias) = pluginSplit($options['model']);
		
		$this->_addForm($htmlAttributes['id']);
		$this->_addFormAttribute('callbacks', $options['callbacks']);
		$this->_addFormAttribute('baseID', $options['baseID']);
		$this->_addFormAttribute('url', $options['url']);
		$this->_addFormAttribute('modelPlugin', $this->modelPlugin);
		$this->_addFormAttribute('modelAlias', $this->modelAlias);
		
		$this->Form->create($this->modelAlias, array('url' => $options['url']));
		
		$out = $this->Bl->sdiv($htmlAttributes);
		if($options['writeForm'] == true)
		{
			$elementOptions = array('type' => am(BuroBurocrataHelper::$defaultSupertype, 'form'));
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
		return $this->internalParam('request', $this->security($url, $modelPlugin, $modelAlias));
	}


/**
 * Creates a param name in format data[_b][$paramName]
 * If a $value is passed, then a '=$value' is appended on string
 * 
 * @access public
 * @param mixed $param A dot separated string or a array
 * @param string $value The param value if the case
 * @return string The param name in Cake format for Burocrata controller
 */
	public function internalParam($paramName, $value = false)
	{
		if(!is_array($paramName))
			$paramName = explode('.', $paramName);
		
		if(!count($paramName))
			return '';
		
		$i_param = 'data[_b][' . implode('][', $paramName) . ']';
		
		if($value !== false)
			$i_param .= '='.$value;
		
		return $i_param;
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
				'name' => $this->internalParam('request'),
				'value' => $this->security($url, $modelPlugin, $modelAlias),
				), array('close_me' => true)
			);
		$out .= $this->Bl->sinput(array(
			'type' => 'hidden',
			'name' => $this->internalParam('layout_scheme'),
			'value' => $View->viewVars['layout_scheme'],
			), array('close_me' => true)
		);
		$out .= $this->Bl->ediv();
		$out .= $this->BuroOfficeBoy->newForm($this->_readFormAttributes());
		
		array_pop($this->_nestedForm);
		$this->Form->end();
		
		return $out;
	}


/**
 * Default submit button (actually is a simple button with javascript)
 * 
 * ### List of valid options:
 * 
 * - `label` - The label of button. Defaults to 'Submit'.
 * - `cancel` - 
 * - `type` - Type of interface ('image' or 'button' or 'link'). Defaults to button.
 * - `src` - A URL for image, in case of use 
 * 
 * @access public
 * @param array $htmlAttributes
 * @param array $options
 * @return string The HTML well formated
 * @todo Canceling the form (maybe in another method)
 * @todo More bricklayerly
 */
	public function submit($htmlAttributes = array(), $options = array())
	{
		$htmlAttributes = $this->addClass($htmlAttributes, 'submit');
		$htmlAttributes = $this->addClass($htmlAttributes, BuroBurocrataHelper::$defaultObjectClass);
		$htmlAttributes['id'] = 'sbmt' . $this->_readFormAttribute('baseID');
		
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
		$htmlAttributes = $this->addClass($htmlAttributes, BuroBurocrataHelper::$defaultContainerClass);
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
		$htmlAttributes = $this->addClass($htmlAttributes, 'instructions');
		$htmlAttributes = $this->addClass($htmlAttributes, BuroBurocrataHelper::$defaultObjectClass);
		
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
		$htmlAttributes = $this->addClass($htmlAttributes, BuroBurocrataHelper::$defaultContainerClass);
		
		if(isset($options['fieldName']))
		{
			$isFieldError = $this->Form->isFieldError($options['fieldName']);
			if($isFieldError)
				$htmlAttributes = $this->addClass($htmlAttributes, 'error');
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
 * - `baseID` - An string that will be appended on every DOM ID. Defaults to uniqid().
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
			'baseID' => uniqid(),
			'model' => false,
			'minChars' => 2,
			'url' => array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'autocomplete'),
			'callbacks' => array()
		);
		$autocomplete_options = am($defaults, $options['options']);
		$parameters = array();
		
		$parameters[] = $this->internalParam('layout_scheme', $View->viewVars['layout_scheme']);
		
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
			$options['fieldName'] = implode('.', array('_b', 'autocomplete', $modelAlias, $Model->displayField));
		}
		
		unset($autocomplete_options['model']);
		unset($options['options']);
		
		$autocomplete_options['parameters'] = implode('&', $parameters);
		
		
		$out = $this->input(
			array(
				'class' => 'autocomplete',
				'id' => 'input'.$autocomplete_options['baseID'],
				'container' => false
			),
			am($options, array(
				'type' => 'text',
				'fieldName' => $options['fieldName']
			))
		);
		
		$out .= $this->Bl->div(
			array('id' => 'div'.$autocomplete_options['baseID'], 'class' => 'autocomplete list'),
			array('escape' => false)
		);
		$out .= $this->inputAutocompleteMessage(
			array('class' => 'nothing_found'),
			array(),
			__('Nothing found.', true)
		);
		$out .= $this->BuroOfficeBoy->autocomplete($autocomplete_options);
		
		return $out;
	}


	function sinputAutocompleteMessage($htmlAttributes = array(), $options = array())
	{
		$htmlAttributes = $this->addClass($htmlAttributes, BuroBurocrataHelper::$defaultObjectClass);
		$htmlAttributes = $this->addClass($htmlAttributes, 'autocomplete');
		$htmlAttributes = $this->addClass($htmlAttributes, 'message');
		$htmlAttributes = $this->addClass($htmlAttributes, 'display:none;', 'style');
		return $this->Bl->sdiv($htmlAttributes, $options);
	}


	function einputAutocompleteMessage()
	{
		return $this->Bl->ediv();
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
			'allow' => array('create', 'modify', 'relate'),
			'baseID' => uniqid()
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
		
		$model_class_name = $model;
		if($plugin)
			$model_class_name = $plugin . '.' . $model_class_name;
		
		// END OF PARSING PARAMS
		
		$out = '';
		
		$hidden_input_id = 'hii'.$baseID;
		$link_id_new = 'lin'.$baseID;
		$link_id_edit = 'lie'.$baseID;
		$update = 'update'.$baseID;
		$acplt_baseID = uniqid();
		$edit_call_baseID = uniqid();
		
		// Input + Autocomplete list + Nothing found
		
		$autocomplete_options = array(
			'options' => array(
				'baseID' => $acplt_baseID,
				'model' => $model_class_name,
				'callbacks' => array(
					'onUpdate' => array('js' => "$('$link_id_new').up().show()"),
					'onSelect' => array(
						'js' => "BuroClassRegistry.get('$baseID').selected(pair);"
					)
				)
			)
		);
		
		if(isset($options['queryField']))
			$options['fieldName'] = $options['queryField'];
		
		$out .= $this->inputAutocomplete(am($input_options, $autocomplete_options));
		
		
		// "Create a new item" link
		
		$out .= $this->inputAutocompleteMessage(
			array('class' => 'action'),
			array('escape' => false),
			$this->Bl->a(array('id' => $link_id_new, 'href' => ''), array(), __('Create a new item', true))
		);
		
		
		// Hidden input that holds the related data ID
		
		$out .= $this->input(array('id' => $hidden_input_id), array('type' => 'hidden', 'fieldName' => $fieldName));
		
		
		// Controls + Error message
		
		$updateble_div = $this->Bl->div(
			array('id' => $update),
			array('escape' => false),
			$this->error(array(), compact('fieldName'))
		);
		
		$links = $this->Bl->a(array('id' => $link_id_edit, 'href' => ''), array(), __('Belongsto edit related data', true));
		
		$actions_div = $this->Bl->div(
			array('class' => 'actions', 'style' => 'display:none;'),
			array('escape' => false),
			$links
		);
		
		$out .= $this->Bl->sdiv(array('class' => 'controls'));
			$out .= $updateble_div;
			$out .= $actions_div;
		$out .= $this->Bl->ediv();
		
		
		
		
		$url_view = array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'view');
		$open_prev_ajax = array(
			'url' => $url_view,
			'params' => array($this->securityParams($url_view, $plugin, $model), $this->internalParam('id') => '@id@'),
			'callbacks' => array(
				'onSuccess' => array(
					'contentUpdate' => $update,
					'js' => "$('$update').next('.actions').show();"
				)
			)
		);
		
		$url_edit = array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'edit');
		$open_form_ajax = array(
				'baseID' => $edit_call_baseID,
				'url' => $url_edit,
				'params' => array(
					$this->securityParams($url_edit, $plugin, $model),
					$this->internalParam('id') => "@to_edit ? this.autocomplete.pair.id : null@",
					$this->internalParam('baseID', $baseID)
				),
				'callbacks' => array(
					'onSuccess' => array('contentUpdate' => $update)
				)
			);
		
		
		$officeboy_options = array();
		$officeboy_options['baseID'] = $baseID;
		$officeboy_options['autocomplete_baseID'] = $acplt_baseID;
		$officeboy_options['callbacks'] = array(
			'onShowForm' => array('ajax' => $open_form_ajax),
			'onShowPreview' => array('ajax' => $open_prev_ajax)
		);
		$out .= $this->BuroOfficeBoy->belongsTo($officeboy_options);
		
		return $out;
	}
}


