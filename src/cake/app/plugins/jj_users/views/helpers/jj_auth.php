<?php

App::import('Lib', 'JjUsers.BigBadGuy');

class JjAuthHelper extends AppHelper
{	
	protected $BigBadGuy;
	public $View;

/**
 * The contructor of the class
 * 
 * @access public
 */
	function __contruct()
	{
		
		$this->__loadClasses();
		return $parent;
	}

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
 * Initializes used and variables
 * 
 * @access protected
 */
	protected function __loadClasses()
	{
		if (!empty($this->BigBadGuy))
			return;
		
		$this->BigBadGuy = ClassRegistry::init('JjUsers.BigBadGuy');
	}


/**
 * Verify the permissions
 * 
 * @access protected
 */
	public function can($what)
	{
		$this->__loadClasses();
		$View = $this->__getView();
		
		$userData = $View->getVar('userData');
		
		return $this->BigBadGuy->can($what, $userData['permissions']);
	
	}
}

