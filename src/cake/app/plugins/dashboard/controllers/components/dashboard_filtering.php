<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */


class DashboardFilteringComponent extends Object
{	
	protected $_controller;

/**
 * Startup callback for initialize
 * 
 * @access public
 */
	function startup(&$controller)
	{
		$this->_controller = $controller;
		
		return true;
	}

/**
 * Custom filter conditions
 * 
 * @access public
 */
	public function getDashboardFilterConditionsByPermission($conditions)
	{
		// some code to treats the conditions array
		
		return $conditions;
	}
	
/**
 * Check a permission to edit modules by filter
 * 
 * @access public
 */
	public function can($data)
	{
		$can = true;
		
		// some code to verify if can
		$can = $this->_controller->JjAuth->can($permission);
		
		return $can;
	}
	
}

