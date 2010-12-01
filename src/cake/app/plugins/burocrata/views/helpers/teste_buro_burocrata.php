<?php
	App::import('Helper', 'Burocrata.BuroBurocrata');
	class TesteBuroBurocrataHelper extends BuroBurocrataHelper
	{
		/**
		 * Overrides the default submit function to wrap the button into a div
		 * 
		 * @access public
		 * @param array $htmlAttributes
		 * @param array $options
		 */
		public function submit($htmlAttributes = array(), $options = array())
		{
			return $this->Bl->div(
				array('class' => 'submit'), 
				array('escape' => false),
				parent::submit($htmlAttributes, $options)
			);
		}
	}