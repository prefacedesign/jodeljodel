<?php

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
 * @todo Use primaryKey instead of id.
 *
 * @return boolean True.
 */
	function afterSave(&$Model, $created) 
	{
		if (!$created)
		{
			if (isset($Model->data[$Model->alias]['modified']))
			{
				$CorkCorktile =& ClassRegistry::init('Corktile.CorkCorktile');
				
				if ($CorkCorktile->updateModifiedDate(
							$Model->data[$Model->alias]['id'], 
							$this->settings[$Model->alias]['type'], 
							$Model->data[$Model->alias]['modified']
						) === false
					)
					return false;
			}			
		}
		return true;
	}
	

}
