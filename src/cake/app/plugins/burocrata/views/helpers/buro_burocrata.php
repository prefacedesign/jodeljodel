<?php
	App::import('Helper', 'Burocrata.XmlTag');
	class BuroBurocrataHelper extends XmlTagHelper
	{
		public $helpers = array('Form', 'Ajax',
			'Typographer.*TypeBricklayer' => array(
				'name' => 'Bl',
				'receive_tools' => true
			)
		);
		
		protected $_nestedInput = false;
		protected $_nestedOrder = 0;
		
		protected $_nestedForm = array();
		protected $_formMap = array();
		protected $_data = false;
		protected $_defaultSuperclass = array('buro');
		
		
		
		/**
		 * Begins a form field.
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
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
			
			if($options['type'] == 'super_field')
			{
				$out .= $this->ssuperfield($htmlAttributes, $options);
			}
			else
			{
				$this->_nestedInput = false;
				if($options['type'] != 'hidden')
					$out .= $this->sinputcontainer($htmlAttributes, $options);
				
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
					$out .= $this->Form->input($options['fieldName'], $inputOptions);
					$out .= $this->Form->error($options['fieldName']);
					
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
				
			$this->_nestedInput = $this->_nestedOrder > 0;
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
			
			return $this->Bl->slabel($htmlAttributes) . $text . $this->Bl->elabel();
		}
		
		
		/**
		 * Starts a form
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
		 * @return	string The HTML well formated
		 */
		public function sform($htmlAttributes = array(), $options = array())
		{
			$View =& ClassRegistry::getObject('View');
			$defaults = array(
				'url' => $View->here,
				'auto_submit' => true,
				'model' => false,
				'data' => false
			);
			$options = am($defaults, $options);
			
			$htmlDefaults = array(
				'id' => $domId = uniqid('frm')
			);
			$htmlAttributes = am($htmlDefaults, $htmlAttributes);
			$htmlAttributes = $this->addClass($htmlAttributes, 'form');
			
			if($options['data'])
				$this->_data = $options['data'];
			elseif($View->data)
				$this->_data = $View->data;
			
			$this->_addForm($htmlAttributes['id']);
			
			$this->model = $options['model'];
			$this->Form->create($options['model'], array('url' => $options['url']));
			return $this->Bl->sdiv($htmlAttributes);
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
		 * 
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
		 * Ends a form
		 *
		 * @access public
		 * @return	string The HTML well formated
		 */
		public function eform()
		{
			array_pop($this->_nestedForm);
			return $this->Bl->ediv();
		}
		
		
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
		 * @return	string The HTML well formated
		 */
		public function ssuperfield($htmlAttributes = array(), $options = array())
		{
			$this->_nestedOrder++;
			$this->_nestedInput = true;
			$htmlAttributes = am(array('class' => 'input'), $htmlAttributes);
			
			extract($options);
			
			$out = $this->Bl->sdiv($htmlAttributes);
			if(isset($label))
				$out .= $this->Bl->sspan() . $label . $this->Bl->espan();
			
			return "\n".$out;
		}
		
		
		/**
		 * Ends a input superfield thats aggregate others inputs
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
		 * @return	string The HTML well formated
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
		 * @return	string The HTML well formated
		 */
		public function sinstructions($htmlAttributes = array(), $options = array())
		{
			return $this->Bl->sspan($htmlAttributes, $options);
		}
		
		
		/**
		 * Ends a instruction enclosure
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
		 * @return	string The HTML well formated
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
		 * @return	string The HTML well formated
		 */
		public function sinputcontainer($htmlAttributes = array(), $options = array())
		{
			$defaults = array();
			if($this->_nestedOrder > 0)
				$defaults['class'] = 'subinput';
			else
				$defaults['class'] = 'input';
			
			$htmlAttributes = am($defaults, $htmlAttributes);
			
			if(isset($options['fieldName']))
			{
				$isFieldError = $this->Form->isFieldError($options['fieldName']);
				if($isFieldError)
					$htmlAttributes['class'] .= ' error';
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
		public function inputBelongsTo($options = array())
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
				case 'autocomplete': $input = $this->belongsToAutocomplete(array('id' => $domId, 'searchField')); break;
				case 'select': $input = $this->belongsToSelect(array('id' => $domId)); break;
				default: // TODO: trigger error `type of `
					return false;
			}
			
			$out = $this->input(array(), array('type' => 'hidden', 'fieldName' => $Model->alias.'.'.$Model->belongsTo[$options['model']]['foreignKey']));
			$out .= $this->label(array('for' => $domId), array(), $inputOptions['label']);
			if(isset($inputOptions['instructions'])) {
				$out .= $this->instructions(array(),array(),$inputOptions['instructions']);
				unset ($inputOptions['instructions']);
			}
			$out .= $input;
			return $out;
		}
		
		
		function belongsToAutocomplete($options = array())
		{
			$out = '';
			// $out = $this->Ajax->autoComplete($options[''], array(
				
			// ));
			// debug(h($out));
			return $out;
		}
	}
	
	
	