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
 * CorkAttachable behavior.
 *
 * CorkAttachable Behavior assures that the Cork metadata is
 * refreshed when there is some alteration of the content
 * attached to the Corktile.
 *
 */
class CorkAttachableBehavior extends ModelBehavior {

/**
 * Settings
 * 
 * Not used yet.
 *
 * @var mixed
 */
	public $settings = array();

/**
 * Setup
 *
 *
 * @param object AppModel
 * @param array $config It should contain: array('type' => 'type_of_cork')
 */
	public function setup(&$Model, $config = array()) 
	{
		$this->settings[$Model->alias] = $config;
	}

/**
 * Called after each save operation.
 *
 * This method calls CorkCorktile::updateModifiedDate() when it is a update request.
 * 
 * @access public
 * @param Model $Model
 * @param boolean $created
 * @return boolean True.
 */
	function afterSave(&$Model, $created) 
	{
		if (!$created)
		{
			$translations = $Model->Behaviors->attached('TradTradutore');

			$CorkCorktile =& ClassRegistry::init('Corktile.CorkCorktile');
			$updated = $CorkCorktile->updateModifiedDate(
				$Model->id,
				$this->settings[$Model->alias]['type'], 
				date('Y-m-d H:i:s'),
				$translations ? $Model->data[$Model->alias . 'Translation']['language'] : false
			);

			if (!$updated)
			{
				return false;
			}
		}
		return true;
	}
	

}
