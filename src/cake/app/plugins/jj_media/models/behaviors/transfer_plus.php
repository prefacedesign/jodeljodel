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

/**
 * Media enhanced plugin
 *
 * Media TranferPlus Behavior
 *
 * @package jj_media
 * @subpackage jj_media.models.behaviors
 */
class TransferPlusBehavior extends ModelBehavior {

/**
 * Settings
 * 
 * @access public
 * @var array
 */
	public $settings = array();


/**
 * Default settings
 * 
 * fieldName
 *  false - Dont store the original filename
 *  string - The table field name
 * 
 * @access protected
 * @var array
 */
	protected $defaultSettings = array(
		'fieldName' => 'original_filename'
	);


/**
 * Merges default settings with provided config and sets default validation options
 * 
 * Calls changeFileName method 
 * 
 * @param Model $Model
 * @param array $settings See defaultSettings for configuration options
 * @return void
 */
	public function setup(&$Model, $settings = array())
	{
		$this->settings[$Model->alias] = $settings + $this->defaultSettings;
	}


/**
 * Run before any or if validation occurs
 * 
 * Calls changeFileName method 
 * 
 * @param Model $Model
 * @return boolean
 */
	public function beforeValidate(&$Model)
	{
		$this->changeFileName($Model);
		return true;
	}


/**
 * Calls changeFileName method if it was not called yet
 * 
 * @param Model $Model
 * @return boolean
 */
	public function beforeSave(&$Model)
	{
		extract($this->settings[$Model->alias]);
		if (!isset($Model->data[$Model->alias][$fieldName]))
			$this->changeFileName($Model);
		return true;
	}


/**
 * Changes the name of file to a uniqID avoiding non ANSI chars on filename and filename collisions.
 * 
 * @param Model $Model
 */
	private function changeFileName(&$Model)
	{
		extract($this->settings[$Model->alias]);
		if (is_string($Model->data[$Model->alias]['file']))
		{
			$dirName = dirname($Model->data[$Model->alias]['file']) . DS;
			$fileName = basename($Model->data[$Model->alias]['file']);
			
			$Model->data[$Model->alias][$fieldName] = $fileName;
			$Model->data[$Model->alias]['file'] = $dirName . $this->hashFileName($Model->data[$Model->alias]['file']);
			
			rename($dirName . $fileName, $Model->data[$Model->alias]['file']);
		}
		elseif (!empty($Model->data[$Model->alias]['file']['name']))
		{
			$Model->data[$Model->alias][$fieldName] = $Model->data[$Model->alias]['file']['name'];
			$Model->data[$Model->alias]['file']['name'] = $this->hashFileName($Model->data[$Model->alias]['file']['name']);
		}
	}
/**
 * Creates a hash for filename
 * 
 * @access private
 */
	private function hashFileName($original_filename)
	{
		return uniqid('', true) . '.' . array_pop(explode('.', $original_filename));
	}
}
