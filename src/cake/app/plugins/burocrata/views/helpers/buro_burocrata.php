<?php
	App::import('Helper', 'Burocrata.XmlTag');
	class BuroBurocrataHelper extends XmlTagHelper
	{
		var $helpers = array('Form');
		
		protected $_nested_input = false;
		protected $_nested_order = 0;
		protected $_nested_form = false;
		protected $_data = false;
		protected $_default_superclass = array('buro');
		
		/**
		 * Begin with a form field. Can be anyting.
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
		 * @return	string The HTML well formated
		 */
		public function iinput($htmlAttributes = array(), $options = array())
		{
			$out = '';
			$defaults = array(
				'type' => 'text',
				'name' => null,
				'label' => null,
				'options' => array()
			);
			$options = am($defaults, $options);
			
			if($options['type'] == 'super_field')
			{
				$this->_nested_order++;
				$out .= $this->isuperfield($htmlAttributes, $options);
			}
			else
			{
				if($options['type'] != 'hidden')
					$out .= $this->iinputcontainer($htmlAttributes, $options);
				
				if(method_exists($this->Form, $options['type']))
				{
					if($options['type'] != 'hidden')
						$out .= $this->label(array(), $options, $options['label']);
					unset($options['label']);
					
					if(isset($options['instructions'])) {
						$out .= $this->instructions(array(),array(),$options['instructions']);
						unset($options['instructions']);
					}
					$inputOptions = array('label' => false, 'error' => false, 'div' => false, 'type' => $options['type']);
					$out .= $this->Form->input($options['name'], $inputOptions);
					$out .= $this->Form->error($options['name']);
				}
				else
				{
					$out .= $this->{Inflector::variable($options['type'])}($options);
				}
				if($options['type'] != 'hidden')
					$out .= $this->finputcontainer();
			}
			return $out;
		}
		

		/**
		 * End of form field. Ends all types of fields.
		 *
		 * @access	public
		 * @return	string The HTML well formated
		 */
		public function finput()
		{
			$this->_nested_order--;
			return $this->fdiv();
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
			if(isset($options['name'])) {
				$fieldName = $options['name'];
			} else {
				$View =& ClassRegistry::getObject('View');
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
			
			return parent::ilabel($htmlAttributes) . $text . parent::flabel();;
		}
		
		
		/**
		 * Starts a input superfield thats aggregate others inputs
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
		 * @return	string The HTML well formated
		 */
		public function isuperfield($htmlAttributes = array(), $options = array())
		{
			$this->_nested_input = true;
			$htmlAttributes = am(array('class' => 'input'),$htmlAttributes);
			
			extract($options);
			
			$out = $this->idiv($htmlAttributes);
			if(isset($label))
				$out .= $this->span(array(),array(), $label);
			
			return "\n".$out;
		}
		
		
		/**
		 * Starts a input container
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
		 * @return	string The HTML well formated
		 */
		public function iinputcontainer($htmlAttributes = array(), $options = array())
		{
			$defaults = array();
			if($this->_nested_order > 0)
				$defaults['class'] = 'subinput';
			else
				$defaults['class'] = 'input';
			
			$htmlAttributes = am($defaults, $htmlAttributes);
			
			if(isset($options['name']))
			{
				$isFieldError = $this->Form->isFieldError($options['name']);
				if($isFieldError)
					$htmlAttributes['class'] .= ' error';
			}
			
			$out = $this->idiv($htmlAttributes,$options);
			return "\n".$out;
		}
		
		
		/**
		 * Ends a input container
		 *
		 * @access public
		 */
		public function finputcontainer()
		{
			return $this->fdiv();
		}
		
		
		/**
		 * Starts a instruction enclosure
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
		 * @return	string The HTML well formated
		 */
		public function iinstructions($htmlAttributes = array(), $options = array())
		{
			return $this->ispan($htmlAttributes, $options);
		}
		
		
		/**
		 * Ends a instruction enclosure
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
		 * @return	string The HTML well formated
		 */
		public function finstructions()
		{
			return $this->fspan();
		}
		
		
		/**
		 * Starts a form
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
		 * @return	string The HTML well formated
		 */
		public function iform($htmlAttributes = array(), $options = array())
		{
			$View =& ClassRegistry::getObject('View');
			$defaults = array(
				'url' => $View->here,
				'auto_submit' => true,
				'model' => false,
				'data' => false
			);
			$options = am($defaults, $options);
			
			if($options['data'])
				$this->_data = $options['data'];
			elseif($View->data)
				$this->_data = $View->data;
			
			$this->model = $options['model'];
			return $this->Form->create(array(
					'model' => $options['model'],
					'url' => $options['url']
			));
		}
		
		
		/**
		 * Ends a form
		 *
		 * @access public
		 * @return	string The HTML well formated
		 */
		public function fform()
		{
			return $this->Form->end();
		}
		
		
		/**
		 * Construct a belongsTo form based on passed variable
		 * The options are:
		 * - `type` Type of form (can be 'autocomplete' or 'select')
		 * - `allow` An array that contains the actions allowed - the default is array('create', 'modify', 'relate')
		 * - `model` The Alias used by related model (there is no default and MUST be passed)
		 * - `actions` An array that defines all the URLs for CRUD actions
		 *
		 * @access	public
		 * @param	array $options An array with non-defaults values
		 * @return	string The HTML well formated
		 * @todo	Error handling and default values
		 */
		public function belongsTo($options = array())
		{
			$inputOptions = $options;
			$options = $options['options'];
			$defaults = array(
				'model' => false,
				'type' => 'autocomplete',
				'allow' => array('create', 'modify', 'relate')
			);
			$options = am($defaults, $options);
			
			// TODO: Trigger error `related model not set`
			if(!$options['model']) return false; 
			
			// TODO: Trigger error `model not find`
			$model = $this->model;
			if (!ClassRegistry::isKeySet($model)) return false;
			$Model =& ClassRegistry::getObject($model);
			
			// TODO: Trigger error `not a belongsTo related model`
			if(!isset($Model->belongsTo[$options['model']])) return false;
			
			$domId = uniqid('blt');
			switch($options['type'])
			{
				case 'autocomplete': $input = $this->belongsToAutocomplete(array('id' => $domId)); break;
				case 'select': $input = $this->belongsToSelect(array('id' => $domId)); break;
				default: // TODO: trigger error `type of `
					return false;
			}
			
			$out = $this->input(array(), array('type' => 'hidden', 'name' => $Model->alias.'.'.$Model->belongsTo[$options['model']]['foreignKey']));
			$out .= $this->label(array('for' => $domId), array(), $inputOptions['label']);
			if(isset($inputOptions['instructions'])) {
				$out .= $this->instructions(array(),array(),$inputOptions['instructions']);
				unset ($inputOptions['instructions']);
			}
			$out .= $input;
			return $out;
		}
	}
	
	
	