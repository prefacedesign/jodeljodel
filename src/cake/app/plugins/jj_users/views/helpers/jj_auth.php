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

