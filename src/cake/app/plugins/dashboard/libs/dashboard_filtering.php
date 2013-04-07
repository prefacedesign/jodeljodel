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

/**
 * A example of class for the Dashboard.additionalFilteringConditions configuration parameter
 */
class DashboardFiltering
{	

/**
 * Custom filter conditions
 * 
 * @access public
 */
	public static function getPermissionConditions(&$Controller, $conditions)
	{
		// some code that treats the conditions array
		return $conditions;
	}
	
/**
 * Check a permission to edit modules by filter
 * 
 * @access public
 */
	public static function can(&$Controller, $data)
	{
		// some code to verify if can
		$can = $Controller->JjAuth->can($permission);
		
		return $can;
	}
}

