<?php
	class BuroBurocrataHelper extends AppHelper
	{
		var $helpers = array('Form');
		
		private $nested_input = false;
		private $nested_form = false;
		
		/**
		 * Most important function.
		 *
		 * @access public
		 * @param  array $htmlAttributes
		 * @param  array $options
		 */
		function field($htmlAttributes = array(), $options = array(), $content = null)
		{
			$defaults = array(
				'type' => 'text',
				'name' => null
			);
			extract(am($defaults, $options));
			
			if($type == 'superfield')
			{
				$this->nested_input = true;
				$out = $this->iInputContainer();
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
		
		function iInputContainer()
		{
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