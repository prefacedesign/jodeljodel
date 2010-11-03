<?php
	class BuroBurocrataHelper extends AppHelper
	{
		var $helpers = array('Form');
		
		private $_nested_input = false;
		private $_nested_form = false;
		
		/**
		 * Most important function ever.
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
		 */
		function field($htmlAttributes = array(), $options = array())
		{
			$defaults = array(
				'type' => 'text',
				'name' => null
			);
			extract(am($defaults, $options));
			
			if($type == 'superfield')
			{
				$this->_nested_input = true;
				$out = $this->iInputContainer($options);
			}
			else
			{
				$out = $this->iInputContainer();
				if(method_exists($this->Form,$type))
				{
					$out.= $this->Form->{$type}($name, $options);
				}
				else
				{
					$out.= $this->{$type}($name, $options);
				}
				$out.= $this->fInputContainer();
			}
			return $out;
		}
		
		function iInputContainer($htmlAttributes = array(), $options = array())
		{
			$out = '<div class="input">';
			if($this->_nested_input)
			{
				$out 
			}
			return '<div>';
		}
		
		function fInputContainer()
		{
			return '</div>';
		}
		
		function __call($function, $params)
		{
		}
	}