<?php

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

