<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */


App::import('Helper', 'Burocrata.XmlTag');
App::import('Lib', 'JjUtils.SecureParams');
/**
 * Main Helper for burocrata plugin
 *
 * PHP versions 5
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.views.helpers
 *
 * @property TypeBricklayerHelper Bl
 * @property HtmlHelper Html
 * @property FormHelper Form
 * @property JodelHelper Jodel
 * @property BuroOfficeBoyHelper BuroOfficeBoy
 * @property BuroCaptionerHelper BuroCaptioner
 */
class BuroBurocrataHelper extends XmlTagHelper
{
	public $helpers = array('Html', 'Form', 'Ajax', 'Js' => 'prototype',
		'Burocrata.BuroOfficeBoy',
		'Burocrata.BuroCaptioner',
		'JjUtils.Jodel',
		'Typographer.*TypeBricklayer' => array(
			'name' => 'Bl',
			'receive_tools' => true
		),
		'Popup.Popup'
	);

	public $modelAlias;
	public $modelPlugin;
	public $View;

	protected $_nestedInput = false;
	protected $_nestedOrder = 0;

	protected $_nestedForm = array();
	protected $_formMap = array();
	
	protected static $defaultSupertype = array('buro');
	protected static $defaultContainerClass = 'buro';
	protected static $defaultObjectClass = 'buro';
	
	protected static $aggregatedInput = array('radio', 'checkbox', 'datetime');

	public function beforeRender()
	{
		parent::beforeRender();
		if (Configure::read() > 0 && ClassRegistry::getObject('view'))
			$this->Html->css('/burocrata/css/ajax_dump', 'stylesheet', array('inline' => false));
	}


/**
 * An alias method for the View::element method that encloses the Jodel conventions
 *
 * @access public
 * @param string $modelClassName The model in format Plugin.Model
 * @param mixed $typeParams 
 * @return string The element rendered
 */
	public function insertForm($modelClassName, $typeParams = array())
	{
		$type= am(self::$defaultSupertype, 'form', $typeParams);
		return $this->Jodel->insertModule($modelClassName, $type);
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
			'error' => null,
			'options' => array(),
			'required' => false,
			'container' => true
		);
		$options = am($defaults, $options);
		$options['close_me'] = false;
		
		if ($options['type'] == 'super_field')
		{
			$out .= $this->ssuperfield($htmlAttributes, $options);
		}
		else
		{
			$container = $options['container'];
			unset($options['container']);
			
			if (
				isset($this->Form->fieldset[$this->modelAlias]) &&
				in_array($options['fieldName'], $this->Form->fieldset[$this->modelAlias]['validates'])
			) {
				$options['required'] = true;
			}
			
			if ($options['type'] != 'hidden' && $container !== false)
				$out .= $this->sinputcontainer(is_array($container) ? $container : array(), $options);
			
			$method = Inflector::variable('input'.$options['type']);
			if (method_exists($this, $method) && empty($options['forceForm']))
			{
				$options['_htmlAttributes'] = $htmlAttributes;
				$out .= $this->{$method}($options);
			}
			elseif (method_exists($this->Form, $options['type']))
			{
				if ($options['label'] !== false && $options['type'] != 'hidden')
				{
					if (in_array($options['type'], self::$aggregatedInput))
					{
						$out .= $this->Bl->h4Dry($options['label']);
					}
					else
					{
						$labelHtmlAttributes = array();
						if (!empty($htmlAttributes['id']))
							$labelHtmlAttributes['for'] = $htmlAttributes['id'];
						$out .= $this->label($labelHtmlAttributes, $options, $options['label']);
						unset($labelHtmlAttributes);
					}
				}
				unset($options['label']);
				
				if (isset($options['instructions'])) {
					$out .= $this->instructions(array(),array(),$options['instructions']);
					unset($options['instructions']);
				}
				$htmlAttributes = $this->addClass($htmlAttributes, self::$defaultObjectClass);
				$htmlAttributes = $this->addClass($htmlAttributes, $this->_readFormAttribute('baseID'), 'buro:form');
				$inputOptions = am($htmlAttributes, $options['options'], array('label' => false, 'legend' => false, 'div' => false, 'type' => $options['type'], 'error' => $options['error']));
				
				if ($inputOptions['type'] == 'radio') 
					$inputOptions['label'] = true;
				elseif ($inputOptions['type'] == 'checkbox')
				{
					// replace cakephp's  hidden field with zeroed default value, but adds the buro:form in it
					$inputOptions['hiddenField'] = false;
					$out .= $this->Form->input($options['fieldName'], array('type' => 'hidden', 'value' => 0)+$htmlAttributes);

					if (isset($options['options']['label']))
						$inputOptions['label'] = $options['options']['label'];
				}
				
				if (!empty($options['fieldName']))
					$out .= $this->Form->input($options['fieldName'], $inputOptions);
				else
					$out .= $this->Bl->input(Set::filter($inputOptions));
			}
			else
			{
				trigger_error('BuroBurocrataHelper::sinput - input type `'.$options['type'].'` not implemented or known.');
				return false;
			}
			
			if ($options['type'] != 'hidden' && $container !== false)
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
		if ($this->_nestedInput)
			return $this->esuperfield();
			
		$this->_nestedInput = --$this->_nestedOrder > 0;
		//return $this->Bl->ediv();
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
		if (isset($options['fieldName'])) {
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
		$htmlAttributes = $this->addClass($htmlAttributes, self::$defaultObjectClass);
		
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
		$options += array('error' => null);
		return $this->Form->error($options['fieldName'], $options['error']);
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
 * - `url` - URL where data will be posted.
 *           Defaults to /burocrata/buro_burocrata/save
 * - `model` - Model className, with plugin name when
 *             appropriate. Defaults to false.
 * - `writeForm` - If true, attempts to write all form, using
 *                 the conventional element. Defaults to false.
 * - `data` - Optional data that will fill out the form.
 *            Defaults to $this->data
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
			'baseID' => $this->baseID(),
			'callbacks' => array(),
			'data' => null
		);
		$options = am($defaults, $options);
		$options['close_me'] = false;
		
		$htmlAttributes = $this->addClass($htmlAttributes, self::$defaultContainerClass);
		$htmlAttributes = $this->addClass($htmlAttributes, 'buro_form');
		$htmlAttributes['id'] = 'frm' . $options['baseID'];
		
		list($this->modelPlugin, $this->modelAlias) = pluginSplit($options['model']);
		
		if (!empty($this->_nestedForm))
			$this->Form->end();
		
		$this->_addForm($htmlAttributes['id']);
		$this->_addFormAttribute('callbacks', $options['callbacks']);
		$this->_addFormAttribute('baseID', $options['baseID']);
		$this->_addFormAttribute('url', $options['url']);
		$this->_addFormAttribute('modelPlugin', $this->modelPlugin);
		$this->_addFormAttribute('modelAlias', $this->modelAlias);
		$this->_addFormAttribute('data', $options['data'] ? $options['data'] : $View->data);
		
		if (!empty($View->params['language']))
		{
			$this->_addFormAttribute('parameters', array($this->internalParam('language') => $View->params['language']));
			$this->_addFormAttribute('language', $View->params['language']);
		}
		
		$this->data = $View->data = $this->_readFormAttribute('data');
		
		if ($this->modelAlias)
		{
			$this->Form->data = $this->data;
			$this->Form->create($this->modelAlias, array('url' => $options['url']));
		}
		
		$out = $this->Bl->sdiv($htmlAttributes);
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
			if (!isset($map[$form_id]))
				$map[$form_id]= array();
			if (!isset($map[$form_id]['subforms']))
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
 * @return boolean 
 */
	protected function _addFormAttribute($attribute, $value, $append = true)
	{
		$current_form = end($this->_nestedForm);
		
		$map =& $this->_formMap;
		foreach($this->_nestedForm as $form_id)
		{
			if (!isset($map[$form_id]))
				return false;
			
			if ($current_form != $form_id) {
				$map =& $map[$form_id]['subforms'];
			} else {
				if ($append && isset($map[$form_id][$attribute])) {
					$map[$form_id][$attribute] = am($map[$form_id][$attribute], $value);
				} else {
					$map[$form_id][$attribute] = $value;
				}
			}
		}
		return true;
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
			if ($form_id != $current_form && isset($map[$form_id]['subforms']))
				$map =& $map[$form_id]['subforms'];
			elseif (isset($map[$form_id]))
				return $map[$form_id];
		}
		return null;
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
		if (isset($attributes[$attribute]))
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
		if (!$this->View)
			return $this->View = &ClassRegistry::getObject('view');
		
		return $this->View;
	}

/**
 * Creates a unique string for use as base for element IDs
 * 
 * @access protected
 * @return string The unique string
 */
	protected function baseID()
	{
		return substr(uniqid(), -6);
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
		return SecureParams::pack(array(substr(Security::hash($this->url($url)), -5), $modelPlugin, $modelAlias), true);
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
		if (!is_array($paramName))
			$paramName = explode('.', $paramName);
		
		if (!count($paramName))
			return '';
		
		$i_param = 'data[_b][' . implode('][', $paramName) . ']';
		
		if ($value !== false)
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
		$modelAlias = $this->_readFormAttribute('modelAlias');
		$modelPlugin = $this->_readFormAttribute('modelPlugin');
		$url = $this->_readFormAttribute('url');
		$View = $this->_getView();
		
		// Internal parameter: REQUEST
		if (!empty($modelAlias))
			$this->_addFormAttribute('parameters', array($this->internalParam('request') => $this->security($url, $modelPlugin, $modelAlias)));
		
		// Internal parameter: TYPE
		$type = $View->getVar('type');
		if (is_array($type))
			$this->_addFormAttribute('parameters', array($this->internalParam('type') => implode('|', $type)));
		
		// Internal parameter: LAYOUT_SCHEME
		$layout_scheme = $View->getVar('layout_scheme');
		if (!empty($layout_scheme))
			$this->_addFormAttribute('parameters', array($this->internalParam('layout_scheme') => $layout_scheme));
		
		$out = $this->Bl->ediv();
		$out .= $this->BuroOfficeBoy->newForm($this->_readFormAttributes());
		
		array_pop($this->_nestedForm);
		if ($this->modelAlias)
			$this->Form->end();
		
		if (!empty($this->_nestedForm))
		{
			$options = $this->_readFormAttributes();
			$this->modelAlias = $options['modelAlias'];
			$this->modelPlugin = $options['modelPlugin'];
			$this->data = $options['data'];
			$View->data = $this->Form->data = $this->data;
			if ($this->modelAlias)
				$this->Form->create($this->modelAlias, array('url' => $options['url']));
		}
		
		return $out;
	}


/**
 * Default submit button (actually is a simple button with javascript)
 * 
 * ### List of valid options:
 * 
 * - `label` - The label of button. Defaults to 'Submit'.
 * - `cancel` - An array with the cancel options (`id`, `label`, `url`). Defaults to false (no cancel link)
 * - `type` - Type of interface ('image' or 'button' or 'link'). Defaults to button.
 * - `src` - A URL for image, in case of use 
 * 
 * @access public
 * @param array $htmlAttributes
 * @param array $options
 * @return string The HTML well formated
 * @todo More bricklayerly
 */
	public function submit($htmlAttributes = array(), $options = array())
	{
		$options += array(
			'cancel' => false,
			'label' => __d('burocrata', 'Burocrata::submit - Submit label', true),
			'baseID' => $this->_readFormAttribute('baseID')
		);
		
		$htmlAttributes['id'] = 'sbmt' . $options['baseID'];
		$this->_addFormAttribute('submit', $htmlAttributes['id']);
		
		if (!empty($options['cancel']))
		{
			if (!is_array($options['cancel']))
				$options['cancel'] = array();
			
			$options['cancel'] += array(
				'htmlAttributes' => array(),
				'label' => __d('burocrata', 'Burocrata::okOrCancel - Cancel label', true)
			);
			$options['cancel']['htmlAttributes']['id'] = 'cncl' . $options['baseID'];
			$this->_addFormAttribute('cancel', $options['cancel']['htmlAttributes']['id']);
		}
		
		return $this->okOrCancel($htmlAttributes, $options);
	}



/**
 * Overloadable functions for layout modifications
 */






/**
 * Overwrites the default button method to put some classes on it
 * 
 * @access public
 * @param  array $htmlAttributes
 * @param  array $options
 * @return string The HTML well formated
 */
	public function sbutton($htmlAttributes = array(), $options = array())
	{
		$htmlAttributes = $this->addClass($htmlAttributes, 'submit');
		$htmlAttributes = $this->addClass($htmlAttributes, self::$defaultContainerClass);
		
		unset($options['close_me']);
		return $this->Bl->sbutton($htmlAttributes, $options);
	}


/**
 * Creates a block containing a Submit button and a Cancel link.
 * The cancel link can be personalized filling the `cancel` parameter on $options
 * 
 * ### The options are:
 * 
 * - `label` - The label of button. Defaults to 'Submit'.
 * - `cancel` - An array with the cancel options (`htmlAttributes`, `label`, `url`)
 * - `type` - Type of interface ('image' or 'button' or 'link'). Defaults to button.
 * - `src` - A URL for image, in case of use
 * - ``
 * 
 * @access public
 * @param  array $htmlAttributes
 * @param  array $options
 * @return string The HTML well formated
 * @todo Implement the `type` option
 */
	public function sokOrCancel($htmlAttributes = array(), $options = array())
	{
		$options = $options + array(
			'label' => __d('burocrata', 'Burocrata::okOrCancel - OK label', true),
			'type' => 'button',
			'src' => null,
			'cancel' => false,
			'baseID' => $this->_readFormAttribute('baseID')
		);
		$options['close_me'] = false;
		
		$cancelOptions = $options['cancel'];
		unset($options['cancel']);
		
		$out = '';
		$out .= $this->button($htmlAttributes, $options, $options['label']);
		
		if ($cancelOptions && is_array($cancelOptions))
		{
			$cancelOptions += array(
				'htmlAttributes' => array(),
				'label' => __d('burocrata', 'Burocrata::okOrCancel - Cancel label', true),
				'url' => ''
			);
			$cancelHtmlAttributes = $cancelOptions['htmlAttributes'] + array('id' => 'cncl'+$options['baseID']);
			unset($cancelOptions['htmlAttributes']);
			$cancelLabel = $cancelOptions['label'];
			unset($cancelOptions['label']);
			
			$out .= $this->Bl->sp(array('class' => 'alternative_option'));
				$out .= ', ';
				$out .= __d('burocrata','anchorList or', true);
				$out .= ' ';
				$out .= $this->Bl->anchor($cancelHtmlAttributes, $cancelOptions, $cancelLabel);
			$out .= $this->Bl->ep();
			$out .= $this->Bl->floatBreak();
		}
		return $out;
	}


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
		$htmlAttributes = $this->addClass($htmlAttributes, self::$defaultContainerClass);
		$htmlAttributes = $this->_mergeAttributes(array('class' => array('input','superfield')), $htmlAttributes);
		
		extract($options);
		
		$out = $this->Bl->sdiv($htmlAttributes);
		if (isset($label))
			$out .= $this->Bl->h6Dry($label);
			
		if (!empty($instructions))
			$out .= $this->instructions(array(), array(), $instructions);
		
		$out .= $this->Bl->sdiv(array('class' => 'superfield_container'));
		
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
		return $this->Bl->ediv() . $this->Bl->ediv();
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
		$htmlAttributes = $this->addClass($htmlAttributes, self::$defaultObjectClass);
		
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
		if ($this->_nestedOrder > 0)
			$defaults['class'] = 'subinput'; //@todo Make the prefix automatic;
		else
			$defaults['class'] = 'input';
		
		$htmlAttributes = am($defaults, $htmlAttributes);
		$htmlAttributes = $this->addClass($htmlAttributes, self::$defaultContainerClass);
		$htmlAttributes = $this->addClass($htmlAttributes, 'input_' . Inflector::underscore($options['type']));

		if ($options['required'])
			$htmlAttributes = $this->addClass($htmlAttributes, 'required');
		
		if (isset($options['fieldName']))
		{
			$isFieldError = $this->Form->isFieldError($options['fieldName']);
			if ($isFieldError)
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
 * Method that creates an TEXTAREA that resizes automagically.
 * 
 * @access public
 * @return string HTML with the needed JS
 */
	public function inputTextarea($options)
	{
		$out = '';
		$inputOptions = array('type' => 'textarea', 'forceForm' => true, 'container' => false, 'label' => false) + $options;
		unset($inputOptions['instructions']);

		extract($options);
		
		$_htmlAttributes = am(array('id' => 'txt' . $this->baseID()), $_htmlAttributes);
		
		// Label
		$out .= $this->label(array(),compact('fieldName'), $label);
		unset($label);
		
		// Instructions
		if (!empty($instructions))
		{
			$out .= $this->instructions(array(), array('close_me' => false), $instructions);
			unset($instructions);
		}
		
		$out .= $this->Bl->div(
			array('class' => array(self::$defaultContainerClass, 'textarea_container')),
			array(),
			$this->Bl->preDry($this->Bl->spanDry() . $this->Bl->br())
			. $this->input($_htmlAttributes, array('error' => false) + $inputOptions)
		);
		
		$out .= $this->error(array(), $inputOptions);
		
		$out .= $this->BuroOfficeBoy->addHtmlEmbScript(sprintf("new BuroDynamicTextarea('%s')", $_htmlAttributes['id']));
		return $out;
	}

/**
 * This input works exactly like the Form::select() with 'multiple' => 'checkbox' (which does not work with Burocrata)
 * 
 * @access public
 * @param array $options An array that defines all configurable parameters
 * @return string The HTML well formated
 * @return 
 */
	function inputMultipleCheckbox($options)
	{
		$checkboxmultiple = $this->Html->tags['checkboxmultiple'];
		$baseID = $this->_readFormAttribute('baseID');
		$this->Html->tags['checkboxmultiple'] = '<input type="checkbox" name="%s[]"%s buro:form="'.$baseID.'" />';
		
		$options += array('options' => array());
		$options['type'] = 'select';
		$options['container'] = false;
		$options['options']['multiple'] = 'checkbox';
		
		$out = '';
		
		if (!empty($options['label']))
			$out .= $this->Bl->h4Dry($options['label']);
		$options['label'] = false;
		
		if (!empty($options['instructions']))
			$out .= $this->instructions(array(),array(),$options['instructions']);
		unset($options['instructions']);
		
		$out .= $this->input(null, $options);
		
		$this->Html->tags['checkboxmultiple'] = $checkboxmultiple;
		
		return $out;
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
		if (!isset($options['options']['model']) && !isset($options['options']['url']))
		{
			// error (`url` or `model` must be set)
			return false;
		}
		
		$defaults = array(
			'baseID' => $this->baseID(),
			'model' => false,
			'minChars' => 2,
			'url' => array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'autocomplete'),
			'callbacks' => array()
		);
		$autocomplete_options = am($defaults, $options['options']);

		if ($this->_readFormAttribute('language'))
		{
			$autocomplete_options['url']['language'] = $this->_readFormAttribute('language');
		}
		
		$parameters = array();
		$parameters[] = $this->internalParam('layout_scheme', $View->viewVars['layout_scheme']);
		
		if ($autocomplete_options['model'])
		{
			list($modelPlugin, $modelAlias) = pluginSplit($autocomplete_options['model']);
			$parameters[] = $this->securityParams($autocomplete_options['url'], $modelPlugin, $modelAlias);
		}
		
		if (!empty($modelAlias) && !isset($options['options']['url']) && (!isset($options['fieldName']) || empty($options['fieldName'])))
		{
			$class_name = $modelAlias;
			if (!empty($modelPlugin))
				$class_name = $modelPlugin . '.' . $class_name;
				
			$Model =& ClassRegistry::init($class_name);
			$options['fieldName'] = implode('.', array('_b', 'autocomplete', $modelAlias, $Model->displayField));
		}
		
		unset($autocomplete_options['model']);
		unset($options['options']);
		
		$autocomplete_options['parameters'] = implode('&', $parameters);
		
		$dataBkp = $this->Form->data;
		$this->Form->data = array();
		$out = $this->input(
			array(
				'class' => 'autocomplete',
				'id' => 'input'.$autocomplete_options['baseID']
			),
			am(
				array('container' => false),
				$options,
				array(
					'type' => 'text',
					'fieldName' => $options['fieldName']
				)
			)
		);
		$this->Form->data = $dataBkp;
		unset($dataBkp);
		
		$out .= $this->Bl->div(
			array('id' => 'div'.$autocomplete_options['baseID'], 'class' => 'autocomplete list'),
			array('escape' => false)
		);
		$out .= $this->inputAutocompleteMessage(
			array('class' => 'nothing_found'),
			array(),
			__d('burocrata','Burocrata: nothing found on autocomplete.', true)
		);
		$out .= $this->BuroOfficeBoy->autocomplete($autocomplete_options);
		
		return $out;
	}

/**
 * Starts a autocomplete message element, used by inputAutocomplete
 * 
 * @access public
 * @param  array $htmlAttributes
 * @param  array $options
 * @return string The HTML well formated
 * @see BuroBurocrataHelper::inputAutocomplete()
 */
	public function sinputAutocompleteMessage($htmlAttributes = array(), $options = array())
	{
		$htmlAttributes = $this->addClass($htmlAttributes, self::$defaultObjectClass);
		$htmlAttributes = $this->addClass($htmlAttributes, 'autocomplete');
		$htmlAttributes = $this->addClass($htmlAttributes, 'message');
		$htmlAttributes = $this->addClass($htmlAttributes, 'display:none;', 'style');
		return $this->Bl->sdiv($htmlAttributes, $options);
	}

/**
 * Ends a autocomplete message element, used by inputAutocomplete
 * 
 * @access public
 * @param  array $htmlAttributes
 * @param  array $options
 * @return string The HTML well formated
 * @see BuroBurocrataHelper::inputAutocomplete
 */
	public function einputAutocompleteMessage()
	{
		return $this->Bl->ediv();
	}


/**
 * Routes all relational inputs to theirs respectives methods.
 * Only `type` param is required here, but the specific method could ask some more options
 * 
 * @access public
 * @param array $options An array with non-defaults values
 * @return string The HTML well formated
 */
	public function inputRelational(array $options)
	{
		if (!isset($options['options']['type']))
			trigger_error('BuroBurocrataHelper::inputRelational - The relational input must receive the [options][type] configuration.');
			
		$input_type = $options['options']['type'];
		unset($options['options']['type']);
		unset($options['type']);
		
		$input = '';
		$method_name = 'inputRelational'.Inflector::camelize($input_type);
		if (!method_exists($this, $method_name))
			trigger_error("BuroBurocrataHelper::inputRelational - input of '$input_type' type is not known.");
		else
			$input = $this->{$method_name}($options);
		
		return $input;
	}
	

/**
 * Construct a relational input that deals with related data based on passed variable
 *
 * ### The options are:
 *
 * - `model` string - The Alias used by related model (there is no default and MUST be passed).
 * - `allow` array - An array that contains the actions allowed - Defaults to array('create', 'modify', 'relate').
 * - `actions` array - (NOT IMPLEMENTED) An array that defines all the URLs for CRUD actions Defaults to BuroBurocrataController actions.
 * - `callbacks` array - An array with possible callbacks with Jodel Callbacks convention.
 * - `texts` array - An array with non default texts for interface. Can have `new_item`, `edit_item` and `nothing_found` parameters
 * - `new_item_text` string - Deprecated use [texts][new_item] instead!
 * - `edit_item_text` string - Deprecated use [texts][edit_item] instead!
 *
 * @access public
 * @param array $options An array with non-defaults values
 * @return string The HTML well formated
 * @todo actions param implementation
 * @todo allow param implementation
 * @todo type param implementation
 * @todo Error handling
 */
	public function inputRelationalUnitaryAutocomplete($options = array())
	{
		$input_options = $options;
		$options = $options['options'];
		$options += array(
			'model' => false,
			'assocName' => false,
			'url' => array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'autocomplete'),
			'allow' => array('create', 'modify', 'relate'),
			'baseID' => $this->baseID(),
			'texts' => array()
		);

		if ($this->_readFormAttribute('language'))
		{
			$options['url']['language'] = $this->_readFormAttribute('language');
		}

		extract($options);
		
		if (!isset($texts['new_item']))		$texts['new_item'] = __d('burocrata','Burocrata: create a new related item', true);
		if (!isset($texts['edit_item']))	$texts['edit_item'] = __d('burocrata','Burocrata: edit related data', true);
		if (!isset($texts['nothing_found']))$texts['nothing_found'] = __d('burocrata','Burocrata: nothing found on autocomplete', true);
		if (!isset($texts['reset_item']))	$texts['reset_item'] = __d('burocrata','Burocrata: choose another related item', true);
		if (!isset($texts['undo_reset']))	$texts['undo_reset'] = __d('burocrata','Burocrata: Bring last item back', true);
		
		if (isset($new_item_text))	$texts['new_item'] = $new_item_text;
		if (isset($edit_item_text))	$texts['edit_item'] = $edit_item_text;
		
		$model_class_name = $model;
		list($plugin, $model) = pluginSplit($model);
		if (!$assocName && !empty($model))
			$assocName = $model;
		
		if (!$assocName) {
			trigger_error('BuroBurocrataHelper::inputRelationalUnitaryAutocomplete - Related model not set on given options [options][model]');
			return false; 
		}
		unset($options['assocName']);
		
		// Usually the Cake core will display a "missing table" or "missing connection"
		// if something went wrong on registring the model
		$ParentModel =& ClassRegistry::init($this->modelPlugin . '.' . $this->modelAlias);
		// But won't hurt test if went ok
		if (!$ParentModel) {
			trigger_error('BuroBurocrataHelper::inputRelationalUnitaryAutocomplete - Parent model could not be found.');
			return false;
		}
		
		$availables = array_keys($ParentModel->belongsTo);
		if (!in_array($assocName, $availables) ) {
			trigger_error('BuroBurocrataHelper::inputRelationalUnitaryAutocomplete - Related model doesn\'t make a unitary relationship. Given \''.$assocName.'\', but availables are: \''.implode('\', \'', $availables).'\'');
			return false;
		}
		$fieldName = implode('.', array($this->modelAlias, $ParentModel->belongsTo[$assocName]['foreignKey']));
		
		
		// if (isset($options['queryField']))
			// $options['fieldName'] = $options['queryField'];
		
		// END OF PARSING PARAMS
		
		$hidden_input_id = 'hii'.$baseID;
		$acplt_baseID = $this->baseID();
		$edit_call_baseID = $this->baseID();
		
		$out = $this->Bl->sdiv(array('id' => 'div'.$baseID));
		
		// Input + Autocomplete list + Nothing found
		
		$autocomplete_options = array(
			'options' => array(
				'baseID' => $acplt_baseID,
				'model' => $model_class_name,
				'callbacks' => array(
					'onUpdate' => array('js' => "BuroCR.get('$baseID').ACUpdated();"),
					'onSelect' => array('js' => "BuroCR.get('$baseID').ACSelected(pair);")
				)
			)
		);
		$out .= $this->inputAutocomplete(am($input_options, $autocomplete_options));
		
		
		// "Create a new item" link
		if (in_array('create', $allow))
			$out .= $this->inputAutocompleteMessage(
				array('class' => 'action'),
				array('escape' => false),
				$this->Bl->a(array('buro:action' => 'new', 'href' => ''), array(), $texts['new_item'])
			);
		
		
		// Hidden input that holds the related data ID
		$out .= $this->input(array('id' => $hidden_input_id), array('type' => 'hidden', 'fieldName' => $fieldName));
		
		
		// Controls + Error message
		
		$data = false;
		if (isset($this->data[$assocName]))
			$data = $this->data[$assocName];
		elseif (isset($this->data[$this->modelAlias][$assocName]))
			$data = $this->data[$this->modelAlias][$assocName];
		
		$module = '';
		if ($data && !empty($data[$ParentModel->{$assocName}->primaryKey]))
			$module = $this->Jodel->insertModule($model_class_name, array('buro', 'view', 'belongsto'), array($model => $data));
		
		
		$updateble_div = $this->Bl->div(
			array('id' => 'update' . $baseID),
			array(),
			$module
		);
		
		$error_div = $this->Bl->div(
			array('id' => 'error' . $baseID),
			array(),
			$this->error(array(), compact('fieldName'))
		);
		
		$links = array(
			in_array('modify', $allow) ? $this->Bl->a(array('buro:action' => 'edit', 'href' => ''), array(), $texts['edit_item']) : '',
			$this->Bl->a(array('buro:action' => 'reset', 'href' => ''), array(), $texts['reset_item']),
			$this->Bl->a(array('buro:action' => 'undo_reset', 'href' => ''), array(), $texts['undo_reset'])
		);
		
		$actions_div = $this->Bl->div(
			array('class' => 'actions'),
			array('escape' => false),
			implode(' ', $links)
		);
		
		$out .= $this->Bl->sdiv(array('class' => 'controls'));
			$out .= $updateble_div;
			$out .= $error_div;
			$out .= $actions_div;
			$out .= $this->Bl->floatBreak();
		$out .= $this->Bl->ediv();
		
		// Ajax call and OfficeBoy call
		$url = array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'unitary');
		if ($this->_readFormAttribute('language'))
		{
			$url['language'] = $this->_readFormAttribute('language');
		}
		$ajax_options = array(
				'baseID' => $edit_call_baseID,
				'url' => $url,
				'params' => array(
					$this->securityParams($url, $plugin, $model),
					$this->internalParam('id') => '#{id}',
					$this->internalParam('action') => "#{action}",
					$this->internalParam('baseID', $baseID)
				),
				'callbacks' => array(
					'onError' => array('js' => "BuroCR.get('$baseID').actionError(json||false);"),
					'onSuccess' => array('js' => "BuroCR.get('$baseID').actionSuccess(json||false);"),
				)
			);
		
		
		$jsOptions = array();
		$jsOptions['baseID'] = $baseID;
		$jsOptions['update_on_load'] = empty($module);
		$jsOptions['autocomplete_baseID'] = $acplt_baseID;
		$jsOptions['callbacks'] = array(
			'onAction' => array('ajax' => $ajax_options)
		);
		$out .= $this->BuroOfficeBoy->relationalUnitaryAutocomplete($jsOptions);
		
		$out .= $this->Bl->ediv();
		
		return $out;
	}

/**
 * Construct a belongsTo form based on passed variable
 *
 *
 *  - `baseID` string The baseID for the input
 *  - `callbacks` array An array with registered callbacks
 *  - `assocName` string The name of model association 
 *  - `auto_order` boolean An boolean that tells if the order can be changed by 
 *                         the user or is changed by the model. Defaults to false
 *                         (ie. user can change the order)
 *  - `texts` array An array of groups of strings to be display on user interface. Accepted 
 *                  groups of strings are: `confirm` witch is an array indexed by action (will display an 
 *                  confirm box before actually performs the action); `title` witch is an string to be 
 *                  displayed on top of every item.
 * @access public
 * @param array $options An array with non-defaults values
 * @return string The HTML well formated
 * @todo actions param implementation
 * @todo allow param implementation
 * @todo Error handling
 */
	public function inputRelationalManyChildren($options = array())
	{
		$input_options = $options;
		$options = $options['options'];
		$options += $defaults = array(
			'baseID' => $this->baseID(),
			'assocName' => false,
			'title' => false,
			'callbacks' => array(),
			'texts' => array('confirm' => array()),
			'auto_order' => null
		);
		extract($options);
		
		$model_class_name = $model;
		list($plugin, $model) = pluginSplit($model);
		if (!$assocName && !empty($model))
			$assocName = $model;
		
		if (!$assocName) {
			trigger_error('BuroBurocrataHelper::inputRelationalManyChildren - Related model not set on given options [options][model]');
			return false; 
		}
		unset($options['assocName']);
		unset($options['type']);
		
		// Usually the Cake core will display a "missing table" or "missing connection"
		// if something went wrong on registering the model
		$ParentModel =& ClassRegistry::init($this->modelPlugin . '.' . $this->modelAlias);
		// But won't hurt test if went ok
		if (!$ParentModel) {
			trigger_error('BuroBurocrataHelper::inputRelationalManyChildren - Parent model could not be found.');
			return false;
		}
		
		$availables = array_keys($ParentModel->hasMany);
		if (!in_array($assocName, $availables) )
		{
			trigger_error('BuroBurocrataHelper::inputRelationalManyChildren - Related model doesn\'t make a many children relationship. Given \''.$assocName.'\', but available(s) are: \''.implode('\', \'', $availables).'\'');
			return false;
		}
		
		$AssocModel = isset($ParentModel->{$assocName})?$ParentModel->{$assocName}:false;
		
		
		// Label
		if(empty($input_options['label']) && $AssocModel)
			$input_options['label'] = Inflector::humanize($AssocModel->table);
		
		$out = $this->Bl->h4Dry($input_options['label']);
		unset($input_options['label']);
		
		
		// Instructions
		if (isset($input_options['instructions']))
		{
			$out .= $this->instructions(array(), array('close_me' => false), $input_options['instructions']);
			unset($input_options['instructions']);
		}
		
		
		
		// Creating the options for _orderedItens method
		
		if (is_null($auto_order))
			$auto_order = !($AssocModel && $AssocModel->Behaviors->attached('Ordered'));
		
		$allowed_content = array(array(
			'model' => $model_class_name,
			'title' => ife ($title,$title,' '),
		));
		
		$parameters = array();
		if (!empty($this->data[$ParentModel->alias][$ParentModel->primaryKey]))
		{
			$foreign_key = $assocName.'.'.$ParentModel->hasMany[$assocName]['foreignKey'];
			$fieldName = $this->_name($foreign_key);
			$parameters['fkBounding'] = array($fieldName => $this->data[$ParentModel->alias][$ParentModel->primaryKey]);
			
			if (!isset($this->data[$assocName]) || !is_array($this->data[$assocName]))
			{
				$method_name = 'findAllBy' . Inflector::camelize($ParentModel->hasMany[$assocName]['foreignKey']);
				$tmp_data = $ParentModel->find('first', array(
					'conditions' => array($ParentModel->alias.'.'.$ParentModel->primaryKey => $this->data[$ParentModel->alias][$ParentModel->primaryKey]),
					'contain' => $AssocModel->alias
				));
				$this->data[$assocName] = $tmp_data[$assocName];
			}
		}
		
		if (!$auto_order && isset($AssocModel->Behaviors->Ordered))
		{
			$fieldName = $this->_name($AssocModel->alias.'.'.$AssocModel->Behaviors->Ordered->settings[$assocName]['field']);
			$parameters['orderField'] = array($fieldName => '#{order}');
		}
		
		$out .= $this->_orderedItens(compact('texts','model_class_name','foreign_key', 'parameters','allowed_content','baseID','callbacks', 'auto_order'));
		
		return $this->Bl->div(array('id' => 'div' . $baseID, 'class' => 'many_children'), array(), $out);
	}


/**
 * Content stream input.
 * 
 * Most of configuraiton must be done on behavior attching and on content_stream configuration.
 * This method assumes that all configuration errors were corrected by behavior and needs only 
 * the foreignKey column name where the content stream ID is stored.
 * 
 * ### The options:
 * - baseID - Well know already. (optional)
 * - foreignKey - The column name. (Defaults to `cs_content_stream_id`)
 * - texts - Very similar to manyChilrend input format. (Defaults similiar too)
 * - callbaks - An array in burocratas callback format. (Defaults to nothing)
 * 
 * @access public
 * @return string All stuff to make it works
 */
	public function inputContentStream($options = array())
	{
		$input_options = $options;
		$options = $options['options'];
		$options += $defaults = array(
			'baseID' => $this->baseID(),
			'foreignKey' => 'cs_content_stream_id',
			'callbacks' => array(),
			'texts' => array('confirm' => array()),
			'url' => array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'list_of_items')
		);
		if ($this->_readFormAttribute('language'))
		{
			$options['url']['language'] = $this->_readFormAttribute('language');
		}
		extract($options);
		
		// Usually the Cake core will display a "missing table" or "missing connection"
		// if something went wrong on registering the model
		$ParentModel =& ClassRegistry::init($this->modelPlugin . '.' . $this->modelAlias);
		// But won't hurt test if went ok
		if (!$ParentModel) {
			trigger_error('BuroBurocrataHelper::inputContentStream - Parent model could not be found.');
			return false;
		}
		
		if ($ParentModel->Behaviors->attached('TradTradutore'))
		{
			$RealModel = &$ParentModel->{$ParentModel->Behaviors->TradTradutore->settings[$ParentModel->alias]['className']};
		}
		else
		{
			$RealModel = &$ParentModel;
		}
		
		// Test if the parent model is ContentStreamed
		if (!$RealModel->Behaviors->attached('CsContentStreamHolder')) {
			trigger_error('BuroBurocrataHelper::inputContentStream - The model need to be attached with ContentStream.CsContentStreamHolder behavior.');
			return false;
		}
		
		// Loads configuration, settings and data
		App::import('Lib', 'ContentStream.CsConfigurator');
		$config = CsConfigurator::getConfig();
		
		$settings = $RealModel->Behaviors->CsContentStreamHolder->settings[$RealModel->alias];
		if (isset($settings['streams'][$options['foreignKey']]))
		{
			$settings = $settings['streams'][$options['foreignKey']];
			$allowed_content = $settings['allowedContents'];
		}
		
		if (empty($this->data[$ParentModel->alias][$options['foreignKey']])) {
			trigger_error('BuroBurocrataHelper::inputContentStream - It is mandatory that the $this->data['.$ParentModel->alias.']['.$options['foreignKey'].'] field be filled.');
			return false;
		}
		
		$ContentStream = &$RealModel->{$settings['assocName']};
		$content_stream_id = $this->data[$ParentModel->alias][$options['foreignKey']];
		$data = $ContentStream->findById($content_stream_id);
		
		// Label
		if(empty($input_options['label']))
			$input_options['label'] = Inflector::humanize($settings['assocName']);
		
		$out = $this->Bl->h6(array(),array('escape' => false), $input_options['label']);
		unset($input_options['label']);
		
		
		// Instructions
		if (isset($input_options['instructions'])) {
			$out .= $this->instructions(array(), array('close_me' => false), $input_options['instructions']);
			unset($input_options['instructions']);
		}
		
		
		// Hidden input
		$out .= $this->input(
			array(),
			array(
				'type' => 'hidden',
				'fieldName' => $options['foreignKey']
			)
		);
		
		// Configuration for _orderedItens method call
		$model_class_name = 'ContentStream.CsItem';
		$parameters['fkBounding'] = array($this->_name('CsItem.cs_content_stream_id') => $content_stream_id);
		$parameters['contentType'] = array($this->_name('CsItem.type') => '#{content_type}');
		
		if ($ContentStream->CsItem->Behaviors->attached('Ordered'))
		{
			$fieldName = $this->_name('CsItem.'.$ContentStream->CsItem->Behaviors->Ordered->settings['CsItem']['field']);
			$parameters['orderField'] = array($fieldName => '#{order}');
		}
		
		$this->sform(array(), array('model' => $settings['assocName'], 'data' => $data));
		$out .= $this->_orderedItens(compact('url', 'texts','model_class_name','foreign_key', 'parameters','allowed_content','baseID','callbacks', 'auto_order'));
		$this->eform();
		
		return $this->Bl->div(array('id' => 'div' . $baseID, 'class' => 'content_stream'), array(), $out);
	}


/**
 * Creates a interface for a list of items (ordenable or not) of just one type of content based on options given
 * 
 * ### Accepted options are:
 *
 *  - `baseID` string The baseID for the input
 *  - `callbacks` array An array with registered callbacks
 *  - `allowed_content` array An array that tells what types of contents are availables on menu
 *  - `parameters` array Additional parameters for passing with action POSTs
 *  - `model_class_name` string The complete name (Plugin.Name) of the main model, 
 *                              i.e. model that holds all the information. No default value.
 *  - `auto_order` boolean An boolean that tells if the order can be changed by 
 *                         the user or is changed by the model. Defaults to false
 *                         (ie. user can change the order)
 *  - `texts` array An array of groups of strings to be display on user interface. Accepted 
 *                  groups of strings are: `confirm` witch is an array indexed by action (will display an 
 *                  confirm box before actually performs the action); `title` witch is an string to be 
 *                  displayed on top of every item.
 *                  
 * 
 * @access protected
 * @param array $options An array whith the options for this ordered list
 * @return string|false The HTML and its script or false, if something went wrong
 */
	protected function _orderedItens($options)
	{
		$options += array(
			'model_class_name' => false, 
			'auto_order' => false, 
			'callbacks' => array(),
			'parameters' => array(),
			'url' =>array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'list_of_items')
		);
		if ($this->_readFormAttribute('language'))
		{
			$options['url']['language'] = $this->_readFormAttribute('language');
		}
		extract($options);
		
		if (empty($model_class_name)) {
			trigger_error('BuroBurocrataHelper::_orderedItens - model_class_name wasn\'t set.');
			return false;
		}
		if (!isset($options['allowed_content']) || !is_array($options['allowed_content'])) {
			trigger_error('BuroBurocrataHelper::_orderedItens - No allowed_content list specified. It must be an array.');
			return false;
		}
		list($model_plugin, $model_name) = pluginSplit($model_class_name);
		$type= am(self::$defaultSupertype, 'view', 'many_children');
		
		$contents = array();
		$Model =& ClassRegistry::init($model_class_name);
		if (!empty($this->data[$model_name]))
		{
			foreach ($this->data[$model_name] as $n => $data)
			{
				$data = array($model_name => $data);
				$contents[] = array(
					'content' => $this->Jodel->insertModule($model_class_name, $type, $data),
					'id' => $data[$Model->alias][$Model->primaryKey],
					'title' => isset($data[$Model->alias]['__title']) ? $data[$Model->alias]['__title'] : ''
				);
			}
		}

		$duplicateIsAvailable = method_exists($Model, 'duplicate');

		// Javascripts
		$ajax_call = array(
			'baseID' => $this->baseID(),
			'url' => $options['url'],
			'params' => array(
				$this->securityParams($options['url'], $model_plugin, $model_name),
				$this->internalParam('id') => "#{id}",
				$this->internalParam('action') => "#{action}",
				$this->internalParam('content_type') => "#{content_type}",
				$this->internalParam('baseID', $baseID),
			),
			'callbacks' => array(
				'onError' => array('js' => "BuroCR.get('$baseID').actionError(json||false);"),
				'onSuccess' => array('js' => "BuroCR.get('$baseID').actionSuccess(json||false);"),
			)
		);
		
		$url = $this->url($url);
		$parameters['request'] = array($this->internalParam('request') => $this->security($options['url'], $model_plugin, $model_name));
		$parameters['contentId'] = array($this->internalParam('id') => '#{id}');
		$parameters['buroAction'] = array($this->internalParam('action') => 'save');
		
		if ($auto_order)
			$ajax_call['params'][$this->internalParam('foreign_key')] = $foreign_key;
		$jsOptions['callbacks'] = array('onAction' => array('ajax' => $ajax_call))+$options['callbacks'];
		
		$jsOptions['templates']['menu'] = $this->orderedItensMenu(array(), array('allowed_content' => $allowed_content));
		$jsOptions['templates']['item'] = $this->orderedItensItem(array('class' => $auto_order?'auto_order':''), compact('duplicateIsAvailable'));
		$jsOptions['contents'] = $contents;
		$jsOptions += compact('auto_order', 'parameters', 'texts', 'baseID', 'url');
		
		
		$out = $this->Bl->br();
		$out .= $this->BuroOfficeBoy->listOfItems($jsOptions);
		return $out;
	}


/**
 * In theory this method is not necessary, but i had to make it 
 * because this fucking helper doesnt call the ending function by itself.
 * It renders only a template {@link http://api.prototypejs.org/language/Template/}
 * 
 * @access public
 * @param array $htmlAttributes
 * @param array $options
 * @return string The result of sorderedItensMenu concatened with the result of eorderedItensMenu
 */
	public function orderedItensMenu($htmlAttributes = array(), $options = array())
	{
		return $this->sorderedItensMenu($htmlAttributes, $options)
			. $this->eorderedItensMenu();
	}


/**
 * Starts an ordered list menu
 * 
 * Must receive a parameter named 'allowed_content' that will be used to create the menu options
 * This parameter format is as follows:
 * {{{
 * 	array(
 * 		array('model' => 'Plugin.Model', 'label' => 'Some label')
 * 	)
 * }}}
 * 
 * @access public
 * @param array $htmlAttributes
 * @param array $options
 * @return string The HTML for a menu of ordered list
 */
	public function sorderedItensMenu($htmlAttributes = array(), $options = array())
	{
		$htmlAttributes = $this->addClass($htmlAttributes, self::$defaultContainerClass);
		$htmlAttributes = $this->addClass($htmlAttributes, 'ordered_list_menu');
		$options = $options + array('allowed_content' => array());
		
		$htmlAttributes['buro:order'] = '#{order}';
		$out = $this->Bl->sdiv($htmlAttributes); // to be closed on BuroBurocrataHelper::sorderedItensMenu
		
		$out .= $this->Bl->div(array('class' => 'border'));
		
		// A menu made of list of content
		$linkList = array();
		foreach ($options['allowed_content'] as $content_type => $content)
		{
			if (!is_array($content)) 
				return !trigger_error('BuroBurocrataHelper::sorderedItensMenu - allowed_content must be an array of arrays.');
			$content += array('title' => Inflector::humanize($content_type));
			
			$linkList[] = array(
				'attr' => array('href' => '/','class' => 'ordered_list_menu_link', 'buro:content_type' => $content_type),
				'options' => array('close_me' => false),
				'name' => $content['title']
			);
		}
		$lastSeparator = ' '.__('anchorList or',true).' ';
		$before = $this->Bl->span(array('class' => 'caption'), array(), __d('burocrata', 'Burocrata::orderdItensMenu - list caption:', true) . ' ');
		$anchorList = $this->Bl->anchorList(array('class' => 'ordered_list_menu_list_list'), compact('linkList', 'lastSeparator', 'before'));
		$cancelLink = $this->Bl->span(array('class' => 'ordered_list_menu_close'), array(),
			$this->Bl->anchor(
				array('href' => '/'),
				array(),
				__d('burocrata','Burocrata::orderdItensMenu - close list', true)
		));
		
		$out .= $this->Bl->div(
			array('class' => 'ordered_list_menu_list'),
			array(), 
			$cancelLink . ' ' . $anchorList . $this->Bl->floatBreak()
		);
		
		// Button that shows the list of content (if more then one item)
		$out .= $this->Bl->button(array('class' => 'ordered_list_menu_add'), array(), $this->Bl->spanDry('+'));
		
		return $out;
	}


/**
 * Ends a ordered list menu
 * 
 * @access public
 * @return string The HTML of an ending div
 */
	public function eorderedItensMenu()
	{
		return $this->Bl->ediv();
	}


/**
 * Render a item of a list based on passed data.
 * 
 * @access public
 * @param array $htmlAttributes
 * @param array $options
 * @return string|false The well formated HTML or false, if something went wrong
 */
	public function orderedItensItem($htmlAttributes = array(), $options = array())
	{
		return $this->sorderedItensItem($htmlAttributes, $options)
			. $this->eorderedItensItem();
	}


/**
 * Starts a item of a ordered list of items
 * 
 * @access public
 * @param array $htmlAttributes
 * @param array $options
 * @return string The HTML for an item on a ordered list of items
 */
	public function sorderedItensItem($htmlAttributes = array(), $options = array())
	{
		$htmlAttributes = $this->addClass($htmlAttributes, self::$defaultContainerClass);
		$htmlAttributes = $this->addClass($htmlAttributes, 'ordered_list_item');
		$htmlAttributes['buro:id'] = '#{id}';
		
		$out = $this->Bl->sdiv($htmlAttributes);
		$out .= $this->Bl->div(array('class' => 'ordered_list_item_title'), array(), '#{title}');
		$out .= $this->orderedItensControls(array(), $options);
		$out .= $this->Bl->floatBreak();
		$out .= $this->Bl->div(array('class' => 'ordered_list_content'), array(), '#{content}');
		return $out;
	}


/**
 * Ends a item of a ordered list of items
 * 
 * @access public
 * @return string The HTML of an ending div
 */
	public function eorderedItensItem()
	{
		return $this->Bl->ediv();
	}

/**
 * Renders a div containing the controls for one item.
 * 
 * @access public
 * @return string The HTML of controls
 */
	public function orderedItensControls($htmlAttributes = array(), $options = array())
	{
		return $this->sorderedItensControls($htmlAttributes, $options)
				.$this->eorderedItensControls();
	}

/**
 * Starts the div of control for one item.
 * 
 * @access public
 * @return string The HTML starting the controls
 */
	public function sorderedItensControls($htmlAttributes = array(), $options = array())
	{
		$htmlAttributes = $this->addClass($htmlAttributes, self::$defaultContainerClass);
		$htmlAttributes = $this->addClass($htmlAttributes, 'ordered_list_controls');
		$out = $this->Bl->sdiv($htmlAttributes);

		$controls = array();
		$label = __d('burocrata','Burocrata::orderedItensControls - up', true);
		$controls[] = $this->Bl->button(
			array('class' => 'ordered_list_up', 'buro:action' => 'up'), 
			array(), 
			$this->Bl->spanDry($label));

		$label = __d('burocrata','Burocrata::orderedItensControls - down', true);
		$controls[] = $this->Bl->button(
			array('class' => 'ordered_list_down', 'buro:action' => 'down'),
			array(), 
			$this->Bl->spanDry($label));

		$label = __d('burocrata','Burocrata::orderedItensControls - delete', true);
		$controls[] = $this->Bl->button(
			array('class' => 'ordered_list_delete', 'buro:action' => 'delete'), 
			array(), 
			$this->Bl->spanDry($label));

		if (!empty($options['duplicateIsAvailable']))
		{
			$label = __d('burocrata','Burocrata::orderedItensControls - duplicate', true);
			$controls[] = $this->Bl->anchor(
				array('class' => 'ordered_list_duplicate', 'buro:action' => 'duplicate'),
				array('url' => ''),
				$label);
		}

		$label = __d('burocrata','Burocrata::orderedItensControls - edit', true);
		$controls[] = $this->Bl->anchor(
			array('class' => 'ordered_list_edit', 'buro:action' => 'edit'), 
			array('url' => ''),
			$label);

		$out .= implode("\n", $controls);
		return $out;
	}

/**
 * Ends the div of control for one item.
 * 
 * @access public
 * @return string The HTML endind the controls
 */
	public function eorderedItensControls()
	{
		return $this->Bl->ediv();
	}


/**
 * Construct a belongsTo form based on passed variable
  *
  * ### The options are:
  *
  * - `model` - The Alias used by related model (there is no default and MUST be passed).
  * - `filterOptions` - An array with conditions to filter the options to list
  * - `multiple` - Multiple select or not (can be true or false). Defaults to false.
  * - `size` - Size of the options that are showed. Defaults to 5.
  *
  * @access public
  * @param array $options An array with non-defaults values
  * @todo actions param implementation
  * @todo allow param implementation
  * @todo type param implementation
  * @todo Error handling
  */
	public function inputRelationalList($options = array())
 	{
 		$options['options'] += array(
 			'model' => false,
			'multiple' => false,
			'size' => 5,
 			'baseID' => $this->baseID(),
			'filterOptions' => array()
 		);
 		$gen_options = $options['options'];
 		unset($options['options']);
 		
 		if (empty($gen_options['model']))
 		{
 			trigger_error('BuroBurocrata::inputRelationalList() - `model` parameter must be set.');
 			return false;
 		}
 		
		$model =& ClassRegistry::init($gen_options['model']);
		$conditions = array();
		if (isset($model->Behaviors->TempTemp->__settings[$model->alias]))
		{
			$sets = $model->Behaviors->TempTemp->__settings[$model->alias];
			$conditions = array($model->alias.'.'.$sets['field'] => false);
		}

		
 		// Setting select input options
 		$options['type'] = 'select';
 		$options['container'] = false;

		if(method_exists($model, 'findFilteredOptions'))
			$options['options']['options'] = $model->{'findFilteredOptions'}($gen_options['filterOptions']);
		else
			$options['options']['options'] = $model->find('list', array('conditions' => $conditions));
 		
		$options['options']['multiple'] = (boolean) $gen_options['multiple'];
 		

		// Setting html attributes
 		$htmlAttributes = $options['_htmlAttributes'];
 		$htmlAttributes = $this->addClass($htmlAttributes, 'list');
 		$htmlAttributes = $this->addClass($htmlAttributes, $gen_options['size'], 'size');

 		return $this->input($htmlAttributes, $options);
	}
	
/**
 * * Construct a HABTM relational input with checkbox
  *
  * ### The options are:
  *
  * - `model` - The Alias used by related model (there is no default and MUST be passed).
  * - `filterOptions` - An array with conditions to filter the options to checkboxes options
  *
  * @access public
  * @param array $options An array with non-defaults values
  * @todo actions param implementation
  * @todo allow param implementation
  * @todo type param implementation
  * @todo Error handling
  */
	public function inputRelationalMultipleCheckbox($options = array())
 	{
 		$options['options'] += array(
 			'model' => false,
 			'baseID' => $this->baseID(),
			'filterOptions' => array()
 		);
 		$gen_options = $options['options'];
 		unset($options['options']);
 		
 		if (empty($gen_options['model']))
 		{
 			trigger_error('BuroBurocrata::inputRelationalMultipleCheckbox() - `model` parameter must be set.');
 			return false;
 		}
 		
		$model =& ClassRegistry::init($gen_options['model']);
		$conditions = array();
		if (isset($model->Behaviors->TempTemp->__settings[$model->alias]))
		{
			$sets = $model->Behaviors->TempTemp->__settings[$model->alias];
			$conditions = array($model->alias.'.'.$sets['field'] => false);
		}
		unset($options['model']);
		
		$options += array('options' => array());
		$options['type'] = 'multiple_checkbox';
		$options['container'] = false;
		if (!empty($options['options']['assocName']))
			$options['fieldName'] = $options['options']['assocName'];
		else
			$options['fieldName'] = $model->alias;
		unset($options['options']['assocName']);
			

		if(method_exists($model, 'findFilteredOptions'))
			$options['options']['options'] = $model->{'findFilteredOptions'}($gen_options['filterOptions']);
		else
			$options['options']['options'] = $model->find('list', array('conditions' => $conditions));

		return $this->input(null, $options);
	}

	
/**
 * Construct a relational input that deals with related data based on passed variable
 *
 * ### The options are:
 *
 * - `model` - The Alias used by related model (there is no default and MUST be passed).
 * - `allow` - An array that contains the actions allowed - Defaults to array('create', 'modify', 'view', 'relate').
 * - `actions` - An array that defines all the URLs for CRUD actions Defaults to BuroBurocrataController actions.
 * - `callbacks` - An array with possible callbacks with Jodel Callbacks convention.
 * - `query_field` - Name of database field that the autocomplete will perform a search
 * - `texts` - An array of configurable texts (`new_item`, `edit_item`, `view_item`, `delete_item`)
 *
 * @access public
 * @param array $options An array with non-defaults values
 * @return string The HTML well formated
 * @todo actions param implementation
 * @todo allow param implementation
 * @todo type param implementation
 * @todo Error handling
 */
	public function inputRelationalEditableList($options = array())
	{
		$input_options = $options;
		$options = $options['options'];
		$options += array(
			'model' => false,
			'assocName' => false,
			'url' => array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'autocomplete'),
			'allow' => array('create', 'modify', 'view', 'relate'),
			'baseID' => $this->baseID(),
			'texts' => array()
		);
		$options['texts'] += array(
			'new_item' => __d('burocrata','Burocrata: create a new related item', true),
			'edit_item' => __d('burocrata','Burocrata: edit related data', true),
			'view_item' => __d('burocrata','Burocrata: view related data', true),
			'unlink_item' => __d('burocrata','Burocrata: unlink related data', true),
			'confirm_unlink' => __d('burocrata','Burocrata: confirm unlinking', true)
		);
		if ($this->_readFormAttribute('language'))
		{
			$options['url']['language'] = $this->_readFormAttribute('language');
		}
		extract($options);
		
		$model_class_name = $model;
		list($plugin, $model) = pluginSplit($model);
		if (!$assocName && !empty($model))
			$assocName = $model;
		
		if (!$assocName) {
			trigger_error('BuroBurocrataHelper::inputRelationalUnitaryAutocomplete - Related model not set on given options [options][model]');
			return false; 
		}
		unset($options['assocName']);
		
		// Usually the Cake core will display a "missing table" or "missing connection"
		// if something went wrong on registring the model
		$ParentModel =& ClassRegistry::init($this->modelPlugin . '.' . $this->modelAlias);
		// But won't hurt test if went ok
		if (!$ParentModel) {
			trigger_error('BuroBurocrataHelper::inputRelationalUnitaryAutocomplete - Parent model could not be found.');
			return false;
		}
		
		$availables = am(array_keys($ParentModel->hasMany), array_keys($ParentModel->hasAndBelongsToMany));
		if (!in_array($assocName, $availables) ) {
			trigger_error('BuroBurocrataHelper::inputRelationalUnitaryAutocomplete - Related model doesn\'t make a unitary relationship. Given \''.$assocName.'\', but availables are: \''.implode('\', \'', $availables).'\'');
			return false;
		}
		
		// END OF PARSING PARAMS
		
		$out = '';
		$items = 'items'.$baseID;
		$update = 'update'.$baseID;
		$acplt_baseID = $this->baseID();
		$edit_call_baseID = $this->baseID();
		
		
		// Input + Autocomplete list + Nothing found
		$autocomplete_options = array(
			'options' => array(
				'baseID' => $acplt_baseID,
				'model' => $model_class_name,
				'callbacks' => array(
					'onUpdate' => array('js' => "BuroCR.get('$baseID').ACUpdated();"),
					'onSelect' => array('js' => "BuroCR.get('$baseID').ACSelected(pair);")
				)
			)
		);
		
		if (isset($options['queryField']))
			$autocomplete_options['fieldName'] = $options['queryField'];
		
		$out .= $this->inputAutocomplete(am($input_options, $autocomplete_options));
		
		
		// "Create a new item" link
		if (in_array('create', $allow))
			$out .= $this->inputAutocompleteMessage(
				array('class' => 'action'),
				array('escape' => false),
				$this->Bl->a(array('buro:action' => 'new', 'href' => ''), array(), $options['texts']['new_item'])
			);
		
		
		// Hidden input that holds the related data ID
		$templates['input'] = $this->input(
			array('value' => '#{id}', 'name' => "data[$assocName][$assocName][]"),
			array('type' => 'hidden')
		);
		$templates['item'] = $this->inputRelationalEditableListItem(compact('allow'));
		
		$type= am(self::$defaultSupertype, 'view', 'editable_list');
		
		$contents = array();
		if (!empty($this->data[$assocName]) && Set::numeric(array_keys($this->data[$assocName])))
		{
			$Model =& ClassRegistry::init($model_class_name);
			foreach ($this->data[$assocName] as $data)
			{
				$data = array($assocName => $data);
				$contents[] = array(
					'content' => $this->Jodel->insertModule($model_class_name, $type, $data),
					'id' => $data[$assocName][$Model->primaryKey]
				);
			}
		}
		
		// Controls + Error message
		$out .= $this->input(array('value' => ''), array('fieldName' => $assocName.'.'.$assocName, 'type' => 'hidden'));
		$out .= $this->Bl->sdiv(array('class' => 'controls'));
			$out .= $this->Bl->div(array('id' => $items));
			$out .= $this->Bl->br();
			$out .= $this->Bl->div(array('id' => $update));
		$out .= $this->Bl->ediv();
		
		
		$url = array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'editable_list');
		if ($this->_readFormAttribute('language'))
		{
			$url['language'] = $this->_readFormAttribute('language');
		}
		$ajax_options = array(
			'url' => $url,
			'params' => array(
				$this->securityParams($url, $plugin, $model),
				$this->internalParam('id') => "#{id}",
				$this->internalParam('action') => "#{action}",
				$this->internalParam('baseID', $baseID),
			),
			'callbacks' => array(
				'onError' => array('js' => "BuroCR.get('$baseID').actionError(json||false);"),
				'onSuccess' => array('js' => "BuroCR.get('$baseID').actionSuccess(json||false);"),
			)
		);
		
		
		$officeboy_options = array();
		$officeboy_options['baseID'] = $baseID;
		$officeboy_options['autocomplete_baseID'] = $acplt_baseID;
		$officeboy_options += compact('texts', 'baseID', 'templates', 'contents');
		$officeboy_options['callbacks'] = array(
			'onAction' => array('ajax' => $ajax_options)
		);
		
		$out .= $this->BuroOfficeBoy->relationalEditableList($officeboy_options);
		
		return $out;
	}

/**
 * Renders a template for a editable list item
 * 
 * @access public
 * @param array $options
 * @return string A HTML template
 */
	public function inputRelationalEditableListItem($options)
	{
		$links = array();
		
		if (in_array('modify', $options['allow']))
			$links[]  = $this->a(array('buro:action' => 'edit', 'href' => ''), array(), '#{edit_item}');
		
		if (in_array('preview', $options['allow']))
			$links[]  = $this->a(array('buro:action' => 'preview', 'href' => ''), array(), '#{view_item}');

		$links[]  = $this->a(array('buro:action' => 'unlink', 'href' => ''), array(), '#{unlink_item}');
	
		$out = $this->Bl->span(array('class' => 'name'), array(), '#{content}');
		$out .= ' ';
		$out .= $this->Bl->span(array('class' => 'controls'), array(), implode(' ', $links));
		
		return $this->Bl->div(array('buro:id' => '#{id}'), array(), $out);
	}
	
/**
 * Construct a belongsTo form based on passed variable
  *
  * ### The options are:
  *
  * - `model` - The Alias used by related model (there is no default and MUST be passed).
  * - `filterOptions` - An array with conditions to filter the options to list
  * - `actions` - An array that defines all the URLs for CRUD actions Defaults to BuroBurocrataController actions.
  * - `callbacks` - An array with possible callbacks with Jodel Callbacks convention.
  *
  * @access public
  * @param array $options An array with non-defaults values
  * @todo actions param implementation
  * @todo allow param implementation
  * @todo type param implementation
  * @todo Error handling
  */
	public function inputRelationalCombo($options = array())
 	{
 		$input_options = $options;
 		$options = $options['options'];
 		$options += array(
 			'model' => false,
 			'assocName' => false,
			'filterOptions' => array(),
			'options' => array()
 		);
 		
		unset($input_options['options']);
		unset($input_options['type']);
		
		$Model =& ClassRegistry::init($options['model']);
		$conditions = array();
		if (isset($Model->Behaviors->TempTemp->__settings[$Model->alias]))
		{
			$sets = $Model->Behaviors->TempTemp->__settings[$Model->alias];
			$conditions = array($Model->alias.'.'.$sets['field'] => false);
		}
		if(method_exists($Model, 'findFilteredOptions'))
			$options_to_list = $Model->{'findFilteredOptions'}($options['filterOptions']);
		else
			$options_to_list = $Model->find('list', array('conditions' => $conditions));
		
		return $this->input(
			array('class' => 'combo'), 
			array(
				'options' => array('options' => array(null => '') + $options_to_list),
				'type' => 'select',
				'container' => false
			) + $input_options
		);
	}
	
	
/**
 * Construct a belongsTo form based on passed variable
 *
 * ### The options are:
 *
 * - `model` - The Alias used by related model (there is no default and MUST be passed).
 * - `filterOptions` - An array with conditions to filter the options to list
 * - `actions` - An array that defines all the URLs for CRUD actions Defaults to BuroBurocrataController actions.
 * - `callbacks` - An array with possible callbacks with Jodel Callbacks convention.
 *
 * @access public
 * @param array $options An array with non-defaults values
 * @return string The HTML well formated
 * @todo actions param implementation
 * @todo allow param implementation
 * @todo type param implementation
 * @todo Error handling
 */
	public function inputRelationalRadio($options = array())
	{
		
		$input_options = $options;
		$options = $options['options'];
		$defaults = array(
			'model' => false,
			'assocName' => false,
			'multiple' => false,
			'baseID' => $this->baseID(),
			'filterOptions' => array()
		);
		$options = am($defaults, $options);

		$model =& ClassRegistry::init($options['model']);
		$conditions = array();
		if (isset($model->Behaviors->TempTemp->__settings[$model->alias]))
		{
			$sets = $model->Behaviors->TempTemp->__settings[$model->alias];
			$conditions = array($model->alias.'.'.$sets['field'] => false);
		}
		if(method_exists($model, 'findFilteredOptions'))
			$options_to_list = $model->{'findFilteredOptions'}($options['filterOptions']);
		else
			$options_to_list = $model->find('list', array('conditions' => $conditions));

		$out = $this->input(
			array(
				'class' => 'radio',
			), 
			array(
				'options' => array('options' => $options_to_list, 'legend' => false),
				'label' => $input_options['label'], 
				'instructions' => $input_options['instructions'], 
				'type' => 'radio', 
				'fieldName' => $input_options['fieldName'],
			)
		);
		
		$out .= $this->Bl->floatBreak();
 		
 		return $out;
 	}

/**
 * Routes all tags inputs to theirs respectives methods.
 * Only `type` param is required here, but the specific method could ask some more options
 * 
 * @access public
 * @param array $options An array with non-defaults values
 * @return string The HTML well formated
 */
	public function inputTags(array $options)
	{
		if (!isset($options['options']['type']))
		{
			trigger_error('BuroBurocrataHelper::inputTags - The tag input must receive the [options][type] configuration.');
			return false;
		}
		
		$input_type = $options['options']['type'];
		unset($options['options']['type']);
		unset($options['type']);
		
		$input = '';
		$method_name = 'inputTags'.Inflector::camelize($input_type);
		if (!method_exists($this, $method_name))
			trigger_error("BuroBurocrataHelper::inputTags - input of '$input_type' type is not known.");
		else
			$input = $this->{$method_name}($options);
		
		return $input;
	}

	
/**
 * Construct a tags field, based in the taggable plugin
 *
 *
 * @access public
 * @param array $options An array with non-defaults values
 * @return string The HTML well formated
 * @todo actions param implementation
 * @todo allow param implementation
 * @todo type param implementation
 * @todo Error handling
 */
	public function inputTagsComma($options = array())
	{
		$input_options = $options;
		$options = $options['options'];
		unset($input_options['options']);
		
		$options += array(
			'model' => false,
			'assocName' => false,
			'baseID' => $this->baseID(),
		);

		$input_options += array(
			'fieldName' => 'tags'
		);

		$out = $this->input(
			array('class' => 'comma',), 
			array('type' => 'text', 'container' => false) + $input_options
		);
 		
 		return $out;
 	}

	/**
	 * Parses the upload parameters and return them for the file input
	 *
	 * @param array $options Array of input configuration, passed on helper method
	 *
	 * @return array An array containing two keys: `gen_options`, that will contain all general options
	 *               and `file_input_options` that will contain options just for the input field
	 * @throws Exception
	 */
	protected function _uploadParams($options)
	{
		$file_input_options = $options;
		unset($file_input_options['options']);

		$file_input_options += array('fieldName' => 'sfil_sored_file_id');
		if (strpos($file_input_options['fieldName'], '.') === false && $this->model())
			$file_input_options['fieldName'] = $this->model() . '.' . $file_input_options['fieldName'];
		
		$defaults = array(
			'baseID' => $this->baseID(),
			'url' => $this->url(array('plugin' => 'jj_media', 'controller' => 'jj_media', 'action' => 'upload')),
			'error' => array(),
			'parameters' => array(),
			'version' => '',
			'model' => 'JjMedia.SfilStoredFile'
		);
		
		$gen_options = $options['options'] + $defaults;
		
		if (isset($file_input_options['error']))
		{
			$gen_options['error'] = $file_input_options['error'];
			unset($file_input_options['error']);
		}

		$file_input_options['value'] = $value = $this->Form->value($file_input_options['fieldName']);
		if (!empty($value)) {
			/** @type SfilStoredFile $SfilStoredFile */
			if (!empty($gen_options['model'])) {
				$SfilStoredFile = ClassRegistry::init($gen_options['model']);
			}
			else {
				$SfilStoredFile = ClassRegistry::init('JjMedia.SfilStoredFile');
			}

			if (!is_a($SfilStoredFile, 'SfilStoredFile')) {
				throw new Exception('The model which will receive the upload must be SfilStoredFile or a child class of it');
			}

			$SfilStoredFile->id = $value;
			$gen_options['aditionalData']['exists'] = $SfilStoredFile->exists();
			if ($gen_options['aditionalData']['exists']) {
				$gen_options['aditionalData']['dlurl'] = $SfilStoredFile->webPath($value, $gen_options['version']);
				$gen_options['aditionalData']['filename'] = $SfilStoredFile->field('original_filename');
			}
		}

		$this->BuroCaptioner->addCaptions('upload');

		return compact('gen_options', 'file_input_options');
	}


	/**
	 * Construct a upload input that will populate the fieldName given with the file database ID
	 *
	 * ### Accepted options:
	 *
	 *  - `model` - The alternate model for the stored file (must be a model extended from SfilStoredFile)
	 *  - `callbacks` - An array with possible callbacks with Jodel Callbacks conven-
	 *    tion.
	 *  - `version`: The version of file that will be returned as URL for preview purposes (available on onSave callback)
	 *  - `error`: A list of possible errors and its texts to be passed for onReject callback
	 *
	 * @access public
	 * @param array $gen_options An array with non-defaults values
	 * @param array $file_input_options
	 * @return string The HTML well formated
	 * @todo Trigger errors
	 */
	protected function _upload($gen_options, $file_input_options) {
		$View = $this->_getView();
		$packed = SecureParams::pack(array($gen_options['version'], $file_input_options['fieldName'], $gen_options['model']));
		list($model_plugin, $model_name) = pluginSplit($gen_options['model']);

		$gen_options['parameters'] += array($this->internalParam('layout_scheme') => $View->getVar('layout_scheme'));
		$gen_options['parameters'] += array($this->internalParam('data') => $packed);

		$out = '';

		$this->sform(array(), array('url' => ''));
		$out .= $this->Bl->sdiv(array('id' => 'div' . $gen_options['baseID']));
			$out .= $this->input(
				array('id' => 'mi' . $gen_options['baseID']),
				array('type' => 'file', 'container' => false, 'fieldName' => $model_name.'.file') + $file_input_options
			);
		$out .= $this->Bl->ediv();
		$this->eform();

		$out .= $this->input(array('id' => 'hi' . $gen_options['baseID']), array('type' => 'hidden', 'fieldName' => $file_input_options['fieldName']));

		// JS class
		$out .= $this->BuroOfficeBoy->upload($gen_options);

		return $out;
	}


	/**
	 * Creates a input for general files, using the general _upload() method
	 * For more details, see {@link _upload()}
	 * This method has one more option:
	 *  - `change_file_text` - Text of link for change the file
	 *
	 * @access public
	 * @param array $options Array of options. See {@link _upload()}.
	 * @return string The HTML of the input
	 * @see BuroBurocrataHelper::_upload()
	 */
	public function inputUpload($options) {
		/**
		 * @type array $gen_options
		 * @type array $file_input_options
		 */
		extract($this->_uploadParams($options));

		if (empty($gen_options['change_file_text'])) {
			$gen_options['change_file_text'] = __d('burocrata', 'Burocrata::inputUpload - Change file', true);
		}

		$act_id = "act{$gen_options['baseID']}";
		$prv_id = "prv{$gen_options['baseID']}";
		$lnk_id = "lnk{$gen_options['baseID']}";
		$chg_id = "chg{$gen_options['baseID']}";

		$fileCaption = __d('burocrata','Burocrata::inputUpload - File: ', true);
		$out = '';

		if (empty($gen_options['callbacks']['onSave']['js']))
			$gen_options['callbacks']['onSave']['js'] = '';
		$gen_options['callbacks']['onSave']['js'] .= "$('{$lnk_id}').update(json.filename).writeAttribute({href: json.dlurl}); $('{$act_id}').show(); $('{$prv_id}').show();";

		if (empty($gen_options['callbacks']['onRestart']['js']))
			$gen_options['callbacks']['onRestart']['js'] = '';
		$gen_options['callbacks']['onRestart']['js'] .= "$('{$act_id}').hide(); $('{$prv_id}').hide();";

		$out .= $this->BuroOfficeBoy->addHtmlEmbScript(
			"$('{$chg_id}').observe('click', function(ev){ev.stop(); BuroCR.get('{$gen_options['baseID']}').again();});"
			. "$('{$act_id}').hide(); $('{$prv_id}').hide();"
		);

		if (!isset($gen_options['callbacks']['ajax']['onSave']['js']))
			$gen_options['callbacks']['ajax']['onSave']['js'] = '';
		$gen_options['callbacks']['ajax']['onSave']['js'] .= "upload.addCaption(BuroCaption.get('upload', 'transfer_ok', {filename: upload.getFileName()}));";

		if (!empty($gen_options['aditionalData']['exists'])) {
			if (!isset($gen_options['callbacks']['ajax']['onLoad']['js']))
				$gen_options['callbacks']['ajax']['onLoad']['js'] = '';
			$gen_options['callbacks']['ajax']['onLoad']['js'] .= "upload.addCaption('$fileCaption ' + upload.getFileName());";
		}

		$out .= $this->_upload($gen_options, $file_input_options);
		$href = !empty($gen_options['aditionalData']['exists']) ? $gen_options['aditionalData']['dlurl'] : '';
		// Div for previews
		$out .= $this->Bl->sdiv(array('id' => $prv_id));
			$filename = __d('burocrata','Burocrata::inputUpload - Download file', true);
			$out .= $this->Bl->pDry(
				"$fileCaption " .
				$this->Bl->a(array('id' => $lnk_id, 'href' => $href), array(), $filename)
			);
		$out .= $this->Bl->ediv();
		
		// Div for actions ID must be `'act' . $gen_options['baseID']`
		$out .= $this->Bl->sdiv(array('id' => $act_id));
			$out .= $this->Bl->a(array('href' => '#', 'id' => $chg_id), array(), $gen_options['change_file_text']);
		$out .= $this->Bl->ediv();
		
		return $out;
	}


	/**
	 * Creates a input for general files, using the general _upload() method
	 * For more details, see {@link _upload()}
	 *
	 * This method has one more option:
	 *  - `change_file_text` - Text of link for change the file
	 *  - `remove_file_text` - Text of link for change the file
	 *
	 * @access public
	 * @param array $options Array of options. See {@link _upload()}.
	 * @return string The HTML of the input
	 * @see BuroBurocrataHelper::_upload()
	 */
	public function inputImage($options) {
		if (empty($options['model'])) {
			$options['options']['model'] = 'JjMedia.SfilImageFile';
		}
		/**
		 * @type array $gen_options
		 * @type array $file_input_options
		 */
		extract($this->_uploadParams($options));

		if (empty($gen_options['change_file_text'])) {
			$gen_options['change_file_text'] = __d('burocrata', 'Burocrata::inputImage - Change image', true);
		}
		if (empty($gen_options['remove_file_text'])) {
			$gen_options['remove_file_text'] = __d('burocrata', 'Burocrata::inputImage - Remove  image', true);
		}

		$this->BuroCaptioner->addCaptions('imageUpload');

		$act_id = "act{$gen_options['baseID']}"; // Div with actions
		$prv_id = "prv{$gen_options['baseID']}"; // Div with the preview
		$img_id = "img{$gen_options['baseID']}"; // The preview image
		$chg_id = "chg{$gen_options['baseID']}"; // Link for changing the file
		$rmv_id = "rmv{$gen_options['baseID']}"; // Link for removing the file

		$out = '';

		if (empty($gen_options['callbacks']['onSave']['js']))
			$gen_options['callbacks']['onSave']['js'] = '';
		$gen_options['callbacks']['onSave']['js'] .= "$('{$img_id}').src = ''; $('{$img_id}').writeAttribute({src: json.url, alt: json.filename}); $('{$act_id}').show(); $('{$prv_id}').show();";
		if (empty($gen_options['callbacks']['onRestart']['js']))
			$gen_options['callbacks']['onRestart']['js'] = '';
		$gen_options['callbacks']['onRestart']['js'] .= "$('{$act_id}').hide(); $('{$prv_id}').hide();";

		if (empty($gen_options['callbacks']['ajax']['onSave']['js']))
			$gen_options['callbacks']['ajax']['onSave']['js'] = '';
		$gen_options['callbacks']['ajax']['onSave']['js'] .= "$('{$img_id}').src = json.dlurl; $('{$prv_id}').show();";
		if (empty($gen_options['callbacks']['ajax']['onRestart']['js']))
			$gen_options['callbacks']['ajax']['onRestart']['js'] = '';
		$gen_options['callbacks']['ajax']['onRestart']['js'] .= "$('{$prv_id}').hide();";
		
		$out .= $this->BuroOfficeBoy->addHtmlEmbScript(
			"$('{$chg_id}').observe('click', function(ev){ev.stop(); BuroCR.get('{$gen_options['baseID']}').again();});"
			. "$('{$rmv_id}').observe('click', function(ev){ev.stop(); BuroCR.get('{$gen_options['baseID']}').again(true);});"
			. "$('{$act_id}').hide();"
		);

		$gen_options['web_path'] = $this->Bl->imageURL($file_input_options['value'], $gen_options['version']);
		$out .= $this->_upload($gen_options, $file_input_options);
		
		// Div for previews
		$exists = !empty($gen_options['web_path']);
		$out .= $this->Bl->sdiv(array('id' => $prv_id, 'style' => $exists ? '' : 'display:none;'));
			$out .= $this->Bl->img(array('id' => $img_id, 'alt' => '', 'src' => $exists ? $gen_options['web_path'] : ''));
		$out .= $this->Bl->ediv();

		// Div for actions ID must be `'act' . $gen_options['baseID']`
		$out .= $this->Bl->sdiv(array('id' => $act_id, 'style' => $exists ? '' : 'display:none;'));
			$change_link = $this->Bl->a(array('href' => '#', 'id' => $chg_id), array(), $gen_options['change_file_text']);
			$remove_link = $this->Bl->a(array('href' => '#', 'id' => $rmv_id), array(), $gen_options['remove_file_text']);
			$out .= $this->Bl->pDry($change_link . __d('burocrata','Burocrata::inputImage - or ', true) . $remove_link);
		$out .= $this->Bl->ediv();
		
		return $out;
	}


/**
 * Renders a input with shortcuts to the four most common textile syntax 
 * (bold, italic, link, image and link for a file)
 * 
 * ### Valid options are:
 * - `baseID`
 * - `enabled_buttons` An array with enabled shortcuts for textile formating
 *                     Valid names are: 'italic', 'bold', 'link', 'image', 'file', 'title'
 *                     Defaults to all enabled
 * - `allow_preview` Boolean value that says if will this input will have a preview button
 *                   Defaults to true
 * 
 * @access public
 * @param array $options
 * @return string The HTML and the Js
 */
	public function inputTextile($options)
	{
		$button_list = array('bold', 'italic', 'link', 'title', 'image', 'file', 'subscript', 'superscript');
		
		$config_options = $options['options'] + array('enabled_buttons' => $button_list, 'allow_preview' => true);
		unset($options['options']);
		
		$baseID = $this->baseID();
		$options = array('type' => 'textarea', 'container' => false) + $options + array('baseID' => $baseID);
		if (isset($config_options['default']))
			$options['options']['default'] = $config_options['default'];
		
		$config_options['enabled_buttons'] = array_intersect($config_options['enabled_buttons'], $button_list);
		
		// `npt` for input
		// `{name}_id` for the popup
		// `l{name}_id` is for the link
		$ids = array('npt', 'prev', 'lprev');
		foreach ($ids as $id)
			${$id.'_id'} = $id . $options['baseID'];
		
		$htmlAttributes = array('id' => $npt_id) + $options['_htmlAttributes'];
		unset($options['_htmlAttributes']);
		
		
		$out = '';
		// Label
		if (!isset($options['label']))
			$options['label'] = null;
		$out .= $this->label(array('for' => $npt_id), $options, $options['label']);
		$options['label'] = false;
		
		// Instructions
		if (!empty($options['instructions']))
		{
			$out .= $this->instructions(array(),array(),$options['instructions']);
			unset($options['instructions']);
		}
		
		// Buttons and theirs popups
		foreach ($config_options['enabled_buttons'] as $button)
		{
			$out .= $this->Bl->anchor(
				array('buro:action' => $button, 'class' => 'link_button buro_textile '.$button.'_textile'),
				array('url' => ''),
				__d('burocrata',sprintf('Burocrata::inputTextile - Add %s', $button), true)
			);
			$popup_method = '_popupTextile'.Inflector::camelize($button);
			if (method_exists($this, $popup_method))
				$out .= $this->{$popup_method}($button . $options['baseID'], $options);
		}
		
		// Preview button, that has a special option
		if ($config_options['allow_preview'])
		{
			$out .= $this->Bl->a(
				array('href' => '', 'class' => 'link_button buro_textile prev_textile', 'id' => $lprev_id), 
				array(), 
				__d('burocrata','Burocrata::inputTextile - Preview', true)
			);
			$out .= $this->_popupTextilePreview($prev_id, $options);

			$url = array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'textile_preview');
			if ($this->_readFormAttribute('language'))
			{
				$url['language'] = $this->_readFormAttribute('language');
			}
			$ajax_options = array(
				'url' => $url,
				'params' => array('data[text]' => "@encodeURIComponent($('{$npt_id}').value)@"),
				'callbacks' => array(
					'onSuccess' => array(
						'contentUpdate' => array('update' => 'div' . $options['baseID']),
						'js' => "showPopup('{$prev_id}')"
					)
				)
			);
			$out .= $this->BuroOfficeBoy->addHtmlEmbScript(
				$this->Js->get('#'.$lprev_id)->event('click', $this->BuroOfficeBoy->ajaxRequest($ajax_options), array('buffer' => false))
			);
		}
		
		$out .= $this->Bl->floatBreak();
		
		// Textarea input
		$out .= $this->input($htmlAttributes, $options);
		
		// Some Javascript (deals with button actions)
		$out .= $this->BuroOfficeBoy->textile($options);
		
		return $out;
		
		/** Textile gettext */
		__d('burocrata','Burocrata::inputTextile - Add bold');
		__d('burocrata','Burocrata::inputTextile - Add italic');
		__d('burocrata','Burocrata::inputTextile - Add link');
		__d('burocrata','Burocrata::inputTextile - Add title');
		__d('burocrata','Burocrata::inputTextile - Add image');
		__d('burocrata','Burocrata::inputTextile - Add file');
		__d('burocrata','Burocrata::inputTextile - Add superscript');
		__d('burocrata','Burocrata::inputTextile - Add subscript');
	}


/**
 * Creates a popup for the Textile input "Add link" button.
 * 
 * @access protected
 * @param string $id The DOM ID for the popup (will be used on Popup helper)
 * @param string $options The array of input options 
 * @return string The HTML and the JS of this popup
 */
	protected function _popupTextileLink($id, $options)
	{
		$popup_link_txt = array(
			'instructions'	=> __d('burocrata','Burocrata::_popupTextileLink - Instructions for link', true),
			'label_text'	=> __d('burocrata','Burocrata::_popupTextileLink - What is the text for this link', true),
			'label_link'	=> __d('burocrata','Burocrata::_popupTextileLink - What is the URL of this link', true),
			'title' 		=> __d('burocrata','Burocrata::_popupTextileLink - Title of link popup', true)
		);
		
		$itlink = 'itlink' . $options['baseID'];
		$iulink = 'iulink' . $options['baseID'];
		
		$popup_config['type'] = 'form';
		$popup_config['title'] = $popup_link_txt['title'];
		$popup_config['callback'] = "if (action == 'ok') BuroCR.get('{$options['baseID']}').insertLink($('$itlink').value, null, $('$iulink').value)";
		$popup_config['content'] = '';
		$popup_config['content'] .= $this->Bl->pDry($popup_link_txt['instructions']);
		
		$popup_config['content'] .= $this->sform(array(), array('url' => ''));
			$popup_config['content'] .= $this->input(array('id' => $itlink), array('container' => false, 'required' => true, 'label' => $popup_link_txt['label_text']));
			$popup_config['content'] .= $this->input(array('id' => $iulink), array('container' => false, 'required' => true, 'label' => $popup_link_txt['label_link']));
		$popup_config['content'] .= $this->eform();
		
		return $this->Popup->popup($id, $popup_config);
	}


/**
 * Creates a popup for the Textile input "Add title" button
 * 
 * @access protected
 * @param string $id The DOM ID for the popup (will be used on Popup helper)
 * @param string $options The array of input options 
 * @return string The HTML and the JS of this popup
 */
	protected function _popupTextileTitle($id, $options)
	{
		$popup_title_txt = array(
			'instructions'	 => __d('burocrata','Burocrata::_popupTextileTitle - Instructions for link', true),
			'label_type'	 => __d('burocrata','Burocrata::_popupTextileTitle - What is the type of this title', true),
			'label_type_tit' => __d('burocrata','Burocrata::_popupTextileTitle - Title', true),
			'label_type_sub' => __d('burocrata','Burocrata::_popupTextileTitle - Subtitle', true),
			'label_text'	 => __d('burocrata','Burocrata::_popupTextileTitle - What is the title', true),
			'title' 		 => __d('burocrata','Burocrata::_popupTextileTitle - Title of title popup', true)
		);
		
		$iilink = 'itititle' . $options['baseID'];
		$ixlink = 'itxtitle' . $options['baseID'];
		
		$popup_config['type'] = 'form';
		$popup_config['title'] = $popup_title_txt['title'];
		$popup_config['callback'] = "if (action == 'ok') BuroCR.get('{$options['baseID']}').insertTitle($('$iilink').value, $('$ixlink').value)";
		$popup_config['content'] = '';
		$popup_config['content'] .= $this->Bl->pDry($popup_title_txt['instructions']);
		
		$popup_config['content'] .= $this->sform(array(), array('url' => ''));
			$popup_config['content'] .= $this->input(
				array('id' => $iilink),
				array(
					'required' => true,
					'container' => false,
					'fieldName' => 'title',
					'type' => 'select', 
					'options' => array('options' => array('h2' => $popup_title_txt['label_type_tit'], 'h3' => $popup_title_txt['label_type_sub'])),
					'label' => $popup_title_txt['label_type']
				)
			);
			$popup_config['content'] .= $this->input(
				array('id' => $ixlink),
				array('container' => false, 'required' => true, 'label' => $popup_title_txt['label_text'])
			);
		$popup_config['content'] .= $this->eform();
		
		return $this->Popup->popup($id, $popup_config);
	}


/**
 * Creates a popup for the Textile input "Preview" button
 * 
 * @access protected
 * @param string $id The DOM ID for the popup (will be used on Popup helper)
 * @param string $options The array of input options 
 * @return string The HTML and the JS of this popup
 */
	protected function _popupTextilePreview($id, $options)
	{
		$popup_title_txt = array(
			'title' => __d('burocrata','Burocrata::_popupTextilePreview - Title of preview popup', true)
		);
		
		$popup_config['type'] = 'notice';
		$popup_config['title'] = $popup_title_txt['title'];
		$popup_config['content'] = '';
		$popup_config['content'] .= $this->Bl->sdiv(array('id' => 'div' . $options['baseID'], 'class' => 'textile buro_textile preview'));
		$popup_config['content'] .= $this->Bl->ediv();
		
		return $this->Popup->popup($id, $popup_config);
	}


/**
 * Creates a popup for the Textile input "File" button, containing a
 * file upload input.
 * 
 * @access protected
 * @param string $id The DOM ID for the popup (will be used on Popup helper)
 * @param string $options The array of input options 
 * @return string The HTML and the JS of this popup
 */
	protected function _popupTextileFile($id, $options)
	{
		$popup_file_txt = array(
			'title'			=> __d('burocrata','Burocrata::_popupTextileFile - Title of `add file` popup', true),
			'label_input'	=> __d('burocrata','Burocrata::_popupTextileFile - Label of file input', true),
		);
		
		$baseID = $this->baseID();
		
		$popup_config['type'] = 'form';
		$popup_config['title'] = $popup_file_txt['title'];
		$popup_config['callback'] = "var ui = BuroCR.get('{$baseID}'); if (ui.uploading && action == 'ok') return false; if (action == 'ok') {BuroCR.get('{$options['baseID']}').insertFile(ui.responseJSON);}";
		$popup_config['content'] = '';
		$popup_config['content'] .= $this->sform(array(), array('model' => 'SfilStoredFile'));
			$popup_config['content'] .= $this->input(array(), array(
				'type' => 'upload',
				'container' => false,
				'label' => $popup_file_txt['label_input'],
				'fieldName' => 'Textile.file_id',
				'options' => array(
					'baseID' => $baseID
				)
			));
		$popup_config['content'] .= $this->BuroOfficeBoy->addHtmlEmbScript("$('$id').observe('popup:opened', function(ev){BuroCR.get('{$baseID}').again();})");
		$popup_config['content'] .= $this->eform();
		
		return $this->Popup->popup($id, $popup_config);
	}


/**
 * Creates a popup for the Textile input "Image" button, containing a
 * image upload input.
 * 
 * @access protected
 * @param string $id The DOM ID for the popup (will be used on Popup helper)
 * @param string $options The array of input options 
 * @return string The HTML and the JS of this popup
 */
	protected function _popupTextileImage($id, $options)
	{
		$popup_file_txt = array(
			'title'			=> __d('burocrata','Burocrata::_popupTextileImage - Title of `add image` popup', true),
			'label_input'	=> __d('burocrata','Burocrata::_popupTextileImage - Label of file input', true),
		);
		
		$baseID = $this->baseID();
		
		$popup_config['type'] = 'form';
		$popup_config['title'] = $popup_file_txt['title'];
		$popup_config['callback'] = "var ui = BuroCR.get('{$baseID}'); if (ui.uploading && action == 'ok') return false; if (action == 'ok') {BuroCR.get('{$options['baseID']}').insertImage(ui.responseJSON);}";
		$popup_config['content'] = '';
		$popup_config['content'] .= $this->sform(array(), array('model' => 'SfilStoredFile'));
			$popup_config['content'] .= $this->input(array(), array(
				'type' => 'image',
				'container' => false,
				'label' => $popup_file_txt['label_input'],
				'fieldName' => 'Textile.image_id',
				'options' => array(
					'version' => 'filter',
					'baseID' => $baseID
				)
			));
		$popup_config['content'] .= $this->BuroOfficeBoy->addHtmlEmbScript("$('$id').observe('popup:opened', function(ev){BuroCR.get('{$baseID}').again();})");
		$popup_config['content'] .= $this->eform();
		
		return $this->Popup->popup($id, $popup_config);
	}


/**
 * Creates a input with a colorpicker.
 * 
 * @access public
 */
	public function inputColor($options)
	{
		$baseID = $this->baseID();
		$htmlAttributes = array(
			'id' => 'inp' . $baseID
		);

		$out = '';
		
		if (!empty($options['label']))
			$out .= $this->label(array(), array(), $options['label']);
		
		if (!empty($options['instructions']))
			$out .= $this->instructionsDry($options['instructions']);
		
		$out .= $this->Bl->div(array('id' => 'samp' . $baseID, 'class' => 'sample'));
		
		$options['type'] = 'text';
		$options['container'] = false;
		$options['label'] = false;
		$options['instructions'] = false;
		$out .= $this->input($htmlAttributes, $options);
		$out .= $this->BuroOfficeBoy->color(compact('baseID'));
		
		return $out;
	}
}

