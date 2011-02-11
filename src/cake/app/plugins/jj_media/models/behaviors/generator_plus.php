<?php
/**
 * Copyright 2010-2011, Preface Design
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010-2011, Preface Design
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

require_once 'Mime/Type.php';

/**
 * Media enhanced plugin
 *
 * Media TranferPlus Behavior
 *
 * @package jj_media
 * @subpackage jj_media.models.behaviors
 */
class GeneratorPlusBehavior extends ModelBehavior {

/**
 * Settings
 * 
 * @access public
 * @var array
 */
	public $settings = array();


/**
 * Current scope for filtering
 * 
 * @access protected
 * @var string
 */
	protected $_scope = array();


/**
 * Default settings
 * 
 * scopeField
 *  string - The table field name
 * 
 * @access protected
 * @var array
 */
	protected $_defaultSettings = array(
		'scopeField' => 'scope'
	);


/**
 * Merges default settings with provided config and sets default validation options
 * 
 * Calls changeFileName method 
 * 
 * @param Model $Model
 * @param array $settings See _defaultSettings for configuration options
 * @return void
 */
	public function setup(&$Model, $settings = array())
	{
		$this->settings[$Model->alias] = $settings + $this->_defaultSettings;
	}


/**
 * Setter for scope variable
 *
 * @access public
 * @param Model $Model
 * @param string|boolean $scope The new scope to set
 * @return mixed The new scope set or false, if no scope is set
 */
	public function setScope(&$Model, $scope = false)
	{
		if (!empty($scope))
			return $this->_scope[$Model->alias] = $scope;
		
		if (isset($this->_scope[$Model->alias]))
			unset($this->_scope[$Model->alias]);
		
		return false;
	}


/**
 * Getter for scope variable
 *
 * @access public
 * @param Model $Model
 * @return mixed The scope set
 */
	public function getScope(&$Model)
	{
		if (!empty($this->_scope[$Model->alias]))
			return $this->_scope[$Model->alias];
		return false;
	}


/**
 * Callback
 *
 * Set (if not set) the current scope for the file
 *
 * @access public
 * @return boolean Always true
 */
	public function beforeSave(&$Model)
	{
		extract($this->settings[$Model->alias]);
		if (!isset($Model->data[$Model->alias][$scopeField]) || empty($Model->data[$Model->alias][$scopeField]))
			$Model->data[$Model->alias][$scopeField] = $this->getScope($Model);
		return true;
	}


/**
 * Callback
 *
 * Dynamically creates the filter configure for image for the GeneratorBehaviour::afterSave callback
 *
 * @param Model $Model
 * @param boolean $created
 * @return boolean
 */
	public function afterSave(&$Model, $created)
	{
		$filters = array();
		$types = array_values(Mime_Type::$name);
		foreach ($types as $type)
			$filters[$type] = array();
		
		$scope = $this->getScope($Model);
		if (!empty($scope))
		{
			$filters = Configure::read('Media.filter_plus.' . $scope);
			foreach ($filters as $type => $filter)
			{
				if (!is_array($filter) || !in_array($type, $types)) {
					unset($filters[$type]);
					continue;
				}
				
				foreach ($filter as $filter_name => $filter_instructions)
				{
					$filters[$type][implode('_', $scope) . '_' . $filter_name] = $filter_instructions;
					unset($filters[$type][$filter_name]);
				}
			}
		}
		Configure::write('Media.filter', $filters);
		
		return true;
	}
}