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
 * @var mixed
 */
	public $settings = array();


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
		if (!isset($Model->data[$Model->alias]['original_name']))
			$this->changeFileName($Model);
		return true;
	}


/**
 * Changes the name of file to a uniqID avoiding non ANSI chars on filename.
 * 
 * @param Model $Model
 */
	private function changeFileName(&$Model)
	{
		if (!empty($Model->data[$Model->alias]['file']['name'])) {
			$original_name = $Model->data[$Model->alias]['file']['name'];
			$Model->data[$Model->alias]['original_name'] = $original_name;
			$Model->data[$Model->alias]['file']['name'] = uniqid('', true) . '.' . array_pop(explode('.', $original_name));
		}
	}
}