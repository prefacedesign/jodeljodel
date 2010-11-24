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
				$htmlAttributes = am(array('container' => array()), $htmlAttributes);
				$this->_nestedInput = false;
				if($options['type'] != 'hidden')
				{
					$out .= $this->sinputcontainer($htmlAttributes['container'], $options);
					unset($htmlAttributes['container']);
				}
				
				if(method_exists($this->Form, $options['type']))
				{
					if($options['type'] != 'hidden')
						$out .= $this->label(array(), $options, $options['label']);
					unset($options['label']);
					
					if(isset($options['instructions'])) {
						$out .= $this->instructions(array(),array(),$options['instructions']);
						unset($options['instructions']);
					}
					$inputOptions = am($htmlAttributes, array('label' => false, 'error' => false, 'div' => false, 'type' => $options['type']));
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
				'url' => array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'save'),
				'writeForm' => false,
				'model' => false,
				'callbacks' => array(),
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
				$elementOptions = array('type' => array('burocrata','form'));
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
		
		
		
		private function _security($url, $modelPlugin, $modelAlias)
		{
			$hash = Security::hash($this->url($url).$modelAlias.$modelPlugin);
			$secure = bin2hex(Security::cipher($modelPlugin.'.'.$modelAlias, $hash));
			return implode('|', array($modelPlugin, $modelAlias, $secure));
		}
		
		
		/**
		 * Ends a form and creates its javascript class
		 *
		 * @access public
		 * @return string The HTML well formated
		 */
		public function eform()
		{
			$this->BuroOfficeBoy->newForm(
				end($this->_nestedForm),
				$this->_readFormAttributes()
			);
			$modelAlias = $this->_readFormAttribute('modelAlias');
			$modelPlugin = $this->_readFormAttribute('modelPlugin');
			$url = $this->_readFormAttribute('url');
			
			$out = $this->Bl->sinput(array(
				'type' => 'hidden',
				'name' => 'data[request]',
				'value' => $this->_security($url, $modelPlugin, $modelAlias),
				), array('close_me' => true)
			);
			$out .= $this->Bl->ediv();
			
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
		
		
		
		
		
		public function inputAutocomplete($options = array())
		{
			$defaults = array(
				'id_base' => uniqid(),
				'model' => false,
				'minChars' => 2,
				'url' => array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'autocomplete'),
				'callbacks' => array()
			);
			$autocomplete_options = am($defaults, $options['options']);
			
			if(!$autocomplete_options['model'])
				return 'Missing `model` param.';
			list($modelPlugin, $modelAlias) = pluginSplit($autocomplete_options['model']);
			$url = $autocomplete_options['url'];
			$autocomplete_options['parameters'] = 'data[request]='.$this->_security($url, $modelPlugin, $modelAlias);
			unset($autocomplete_options['model']);
			
			$this->BuroOfficeBoy->autoComplete($autocomplete_options);
			
			$out = $this->input(array('class' => 'autocomplete', 'id' => 'input'.$autocomplete_options['id_base']),
				array(
					'type' => 'text',
					'fieldName' => $options['options']['fieldName']
				)
			);
			$out .= $this->Bl->div(array('id' => 'div'.$autocomplete_options['id_base']), array('close_me' => false), '');
			
			return $out;
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
				'assocName' => false,
				'url' => array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'autocomplete'),
				'type' => 'autocomplete',
				'allow' => array('create', 'modify', 'relate')
			);
			$options = am($defaults, $options);
			
			// TODO: Trigger error `related model not set`
			if(!$options['assocName']) return 'related model not set'; 
			
			// TODO: Trigger error `parent model not found`
			$model = $this->modelAlias;
			if (!ClassRegistry::isKeySet($model)) return 'parent model not found';
			$Model =& ClassRegistry::getObject($model);
			
			// TODO: Trigger error `not a belongsTo related model`
			if(!isset($Model->belongsTo[$options['assocName']])) return 'not a belongsTo related model';
			$belongs_to_config = $Model->belongsTo[$options['assocName']];
			
			
			$out = $this->input(array(), array('type' => 'hidden', 'fieldName' => $Model->alias.'.'.$belongs_to_config['foreignKey']));
			
			// Creates an input
			$domId = uniqid('blt');
			$out .= $this->label(array('for' => $domId), array(), $inputOptions['label']);
			if(isset($inputOptions['instructions'])) {
				$out .= $this->instructions(array(),array(),$inputOptions['instructions']);
				unset ($inputOptions['instructions']);
			}
			
			switch($options['type'])
			{
				case 'autocomplete': $input = $this->belongsToAutocomplete(array('id' => $domId, 'searchField')); break;
				case 'select': $input = $this->belongsToSelect(array('id' => $domId)); break;
				default: // TODO: trigger error `type of `
					return false;
			}
			$out .= $input;
			
			$divId = uniqid('div');
			$out .= $this->Bl->div(array('id' => $divId));
			
			return $out;
		}
		
		
		function belongsToAutocomplete($options = array())
		{
			$out = $this->BuroOfficeBoy->autoComplete($options['url'], array(
				
			));
			// debug(h($out));
			return $out;
		}
	}
	
	
	