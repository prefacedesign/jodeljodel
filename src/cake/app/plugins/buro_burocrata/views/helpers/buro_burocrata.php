<?php
	App::import('Helper', 'BuroBurocrata.XmlTag');
	class BuroBurocrataHelper extends XmlTagHelper
	{
		var $helpers = array('Form');
		
		private $_nested_input = false;
		private $_nested_order = 0;
		private $_nested_form = false;
		
		
		/**
		 * Begin with a form field. Can be anyting.
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
		 * @return	string The HTML well formated
		 */
		function iinput($htmlAttributes = array(), $options = array())
		{
			$out = '';
			$defaults = array(
				'type' => 'text',
				'name' => null,
				'label' => null
			);
			extract(am($defaults, $options));
			
			if($type == 'super_field')
			{
				$this->_nested_order++;
				$out .= $this->isuperfield($htmlAttributes, $options);
			}
			else
			{
				$out .= $this->iinputcontainer($htmlAttributes, $options);
				unset($options['label']);
				if(method_exists($this->Form,$type))
				{
					$out .= $this->Form->label($name, $label);
					if(isset($options['instructions'])) {
						$out .= $this->instructions(array(),array(),$options['instructions']);
						unset ($options['instructions']);
					}
					$out .= $this->Form->{$type}($name, $options);
					$out .= $this->Form->error($name);
				}
				else
				{
					$out .= $this->{$type}($name, $options);
				}
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
		function finput()
		{
			$this->_nested_order--;
			return $this->fdiv();
		}
	
		
		/**
		 * Starts a input "aggregator"
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
		 * @return	string The HTML well formated
		 */
		function isuperfield($htmlAttributes = array(), $options = array())
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
		function iinputcontainer($htmlAttributes = array(), $options = array())
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
		
		function finputcontainer()
		{
			return $this->fdiv();
		}
		
		function iinstructions($htmlAttributes = array(), $options = array())
		{
			return $this->ispan($htmlAttributes, $options);
		}
		
		function finstructions()
		{
			return $this->fspan();
		}
		
		function iform($htmlAttributes = array(), $options = array())
		{
			$View =& ClassRegistry::getObject('View');
			$defaults = array(
				'url' => $View->here,
				'auto_submit' => true,
				'model' => false
			);
			$options = am($defaults, $options);
			
			return $this->Form->create($options['model'], array(
					'url' => $options['url']
			));
		}
	}
	
	
	