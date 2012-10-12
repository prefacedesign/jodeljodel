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
 * @access public
 * @param Model $Model
 * @param boolean $created
 * @return boolean True.
 */
	function afterSave(&$Model, $created) 
	{
		if (!$created)
		{
			$data = $Model->read();
			if (isset($data[$Model->alias]['modified']))
			{
				$CorkCorktile =& ClassRegistry::init('Corktile.CorkCorktile');
				
				if ($CorkCorktile->updateModifiedDate(
							$data[$Model->alias][$Model->primaryKey], 
							$this->settings[$Model->alias]['type'], 
							$data[$Model->alias]['modified']
						) === false
					)
					return false;
			}			
		}
		return true;
	}
	

}
