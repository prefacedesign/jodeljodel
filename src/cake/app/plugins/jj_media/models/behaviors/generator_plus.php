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
require_once 'Mime/Type.php';

/**
 * Media enhanced plugin
 *
 * Media TranferPlus Behavior
 *
 * @package    jj_media
 * @subpackage jj_media.models.behaviors
 * @todo       Figure some way to work with Generator::make from media plugin
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
	 * @param AppModel $Model
	 * @param array    $settings See _defaultSettings for configuration options
	 *
	 * @return void
	 */
	public function setup (&$Model, $settings = array()) {
		$this->settings[$Model->alias] = $settings + $this->_defaultSettings;
	}

	/**
	 * Setter for scope variable
	 *
	 * @access public
	 *
	 * @param AppModel       $Model
	 * @param string|boolean $scope The new scope to set
	 *
	 * @return mixed The new scope set or false, if no scope is set
	 */
	public function setScope (&$Model, $scope = false) {
		if (!empty($scope)) {
			return $this->_scope[$Model->alias] = $scope;
		}

		if (isset($this->_scope[$Model->alias])) {
			unset($this->_scope[$Model->alias]);
		}

		return false;
	}


	/**
	 * Getter for scope variable
	 *
	 * @access public
	 *
	 * @param Model $Model
	 *
	 * @return mixed The scope set
	 */
	public function getScope (&$Model) {
		if (!empty($this->_scope[$Model->alias])) {
			return $this->_scope[$Model->alias];
		}

		return false;
	}


	/**
	 * This method searches on posted data the input name that will receive the id of the uploaded file.
	 * Based on its name, this method returns the current scope for get the filters.
	 *
	 * @access public
	 *
	 * @param AppModel $Model
	 * @param string   $fieldName The field name of related model foreign key
	 *
	 * @return string|boolean The scope if found, or false if not
	 */
	public function findTheScope (&$Model, $fieldName) {
		if (empty($fieldName)) {
			return false;
		}

		$this->loadConfigure();
		/** @type array[] $filters */
		$filters = Configure::read('Media.filter_plus');

		foreach ($filters as $scope => $filter) {
			if (!isset($filter['fields']) || !is_array($filter['fields'])) {
				continue;
			}
			if (in_array($fieldName, $filter['fields'])) {
				return $scope;
			}
		}

		return null;
	}


	/**
	 * Callback
	 *
	 * Set (if not set) the current scope for the file
	 *
	 * @access public
	 *
	 * @param AppModel $Model
	 *
	 * @return boolean Always true
	 */
	public function beforeSave (&$Model) {
		/**
		 * @var string $scopeField
		 */
		extract($this->settings[$Model->alias]);
		if (!isset($Model->data[$Model->alias][$scopeField]) || empty($Model->data[$Model->alias][$scopeField])) {
			$Model->data[$Model->alias][$scopeField] = $this->getScope($Model);
		}

		return true;
	}


	/**
	 * Callback
	 * Calls the createGeneratorConfigure method, for populate the `Media.filter` configure
	 *
	 * @param AppModel $Model
	 * @param boolean  $created
	 *
	 * @return boolean
	 */
	public function afterSave (&$Model, $created) {
		$scope = $this->getScope($Model);
		$this->createGeneratorConfigure($Model, $scope);

		return true;
	}


	/**
	 * Callback
	 * Populates the $Model->data with the current register that will be deleted
	 * for the callback afterDelete
	 *
	 * @access public
	 *
	 * @param AppModel $Model
	 * @param bool     $cascade
	 *
	 * @return bool|mixed
	 */
	public function beforeDelete (&$Model, $cascade) {
		$Model->read();

		return true;
	}


	/**
	 * Callback
	 * Calls createGeneratorConfigure to populate the Media.filter configure and
	 * uses that configuation for unlink the filtered files.
	 *
	 * @access public
	 *
	 * @param AppModel $Model
	 */
	public function afterDelete (&$Model) {
		if (empty($Model->data[$Model->alias]['transformation'])) {
			return;
		}

		$scope = $Model->data[$Model->alias]['transformation'];
		$this->createGeneratorConfigure($Model, $scope);

		$filename = $Model->data[$Model->alias]['basename'];

		/** @type array[] $filters */
		$filters = Configure::read('Media.filter');
		foreach ($filters as $type => $filter) {
			if (empty($filter) || !is_array($filter)) {
				continue;
			}

			$versions = array_keys($filter);
			foreach ($versions as $version) {
				@unlink(MEDIA_FILTER . $version . DS . $Model->data[$Model->alias]['dirname'] . DS . $filename);
			}
		}
	}


	/**
	 * Dynamically creates the filter configure for image for the GeneratorBehaviour::afterSave callback
	 *
	 * @access public
	 *
	 * @param AppModel $Model
	 * @param string   $scope
	 */
	public function createGeneratorConfigure (&$Model, $scope) {
		$this->loadConfigure();

		$filters = array();
		$types = array_values(Mime_Type::$name);
		foreach ($types as $type) {
			$filters[$type] = array();
		}

		if (!empty($scope)) {
			/** @type array $filter_plus */
			$filter_plus = Configure::read('Media.filter_plus.' . $scope);
			foreach ($filter_plus as $type => $filter) {
				if (!is_array($filter) || !in_array($type, $types)) {
					continue;
				}

				foreach ($filter as $filter_name => $filter_instructions) {
					$filters[$type][$scope . '_' . $filter_name] = $filter_instructions;
				}
			}
		}
		Configure::write('Media.filter', $filters);
	}


	/**
	 * Loads the configure file (with all layout_scheme variables filled)
	 *
	 * @access protected
	 */
	protected function loadConfigure () {
		if (Configure::read('Media.filter_plus')) {
			return;
		}

		/** @type string[] $layout_schemes */
		$layout_schemes = Configure::read('Typographer.layout_schemes');
		foreach ($layout_schemes as $layout_scheme) {
			@include(APP . 'plugins' . DS . 'typographer' . DS . 'config' . DS . $layout_scheme . '_config.php');

			$config_name = Inflector::camelize($layout_scheme);
			$variable_name = Inflector::variable($layout_scheme . '_tools');
			$tools = Configure::read("Typographer.{$config_name}.tools");
			if ($tools) {
				${$variable_name} = $tools;
			}
		}

		require APP . 'plugins' . DS . 'jj_media' . DS . 'config' . DS . 'core.php';
	}
}
