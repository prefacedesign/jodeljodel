<?php

App::import('Lib', 'JjUsers.BigBadGuy');

class JjAuthHelper extends AppHelper
{

/**
 * Caches a reference to the View object
 * 
 * @access public
 */
	public $View;

/**
 * Gets and caches an View object reference
 *
 * @access protected
 * @return object The View object reference
 */
	protected function __getView()
	{
		if (!$this->View)
			return $this->View = &ClassRegistry::getObject('view');
		
		return $this->View;
	}	

/**
 * Verify the permissions
 * 
 * @access protected
 */
	public function can($what)
	{
		$View = $this->__getView();
		
		$userData = $View->getVar('userData');
		
		return BigBadGuy::can($what, $userData['permissions']);
	
	}
}

