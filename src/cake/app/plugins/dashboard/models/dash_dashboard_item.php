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
 * @todo Revamp data structure.
 * @todo Introduce tag copying.
 * @todo Use loadModel instead of ClassRegistry.
 * @todo Use only 'type' => 'person' instead of storing the name of the Cake Models'
 */

/**
 * A model for the dash_dashboard_items table
 * Each DashDashboardItem is a summary of a dashable Model
*/
class DashDashboardItem extends AppModel
{
/**
 * Model name
 * 
 * @var string
 * @access public
 */
	var $name = 'DashDashboardItem';
	
	var $actsAs = array(
		'JjUtils.Encodable' => array(
			'fields' => array(
				'idiom' => 'serialize'
			)
		)
	);
	
/**
 * Inserts or updates one item in the dashboard
 *
 * @param array $data The default array that describes the dash_dashboard_items table
 * @param boolean $updateDashable If true, updates the original model table, otherwise only updates the dashboard table
 *                                This parameter is used to prevend infinite loops
 * @todo This function doesn't make any sense.
 */
	function saveDashItem($data, $updateDashable = false)
	{
		$this->save($data);
		
		if($updateDashable)
		{
			$dashableModel = ClassRegistry::init(array('class' =>  $data['Model']));
			$dashableModel->updateFromDashInfo($data);
		}
	}

	
/*
 * Deletes an item from the dashboard and
 *
 * @param strgin $id The dashboard_item id  ('Modelname@ID.     ex: 'Event@32)
 * @param updateDashable if true, updates the original model table, otherwise only updates the dashboard table
 * 											This parameter is used to prevend infinite loops
 * @todo Analyze wheter this function is deprecated.
 */
	function removeDashItem($id, $updateDashable = false)
	{
		$this->delete($id);
		
		if($updateDashable)
		{
			@list($model, $id) = explode('@', $id);
			
			if (empty($model) || empty($id))
				return false;
			
			$dashableModel = ClassRegistry::init(array('class' =>  $model));
			$dashableModel->delete($id);
		}
	}


/**
 * Deletes a item from the table, by deleting the original item. As everything 
 * is synchronized it should also delete the Dashboard entry.
 *
 * @access public
 * @param string $id The item's id in dashboard (`Modelname@ID`   ex: `Event@32`)
 * @return boolean True if succesful, false if otherwise.
 */
	function deleteItem($id)
	{
		$item = $this->find('first', array(
			'conditions' => array('DashDashboardItem.id' => $id),
			'fields' => array('DashDashboardItem.dashable_id', 'DashDashboardItem.type')
		));
		
		if (empty($item['DashDashboardItem']['type']) || empty($item['DashDashboardItem']['dashable_id']))
			return false;
		
		$module = Configure::read('jj.modules.' . $item['DashDashboardItem']['type']);	
		$dashableModel = ClassRegistry::init($module['model']);
		
		if (method_exists($dashableModel, 'dashDelete'))
			$return = $dashableModel->dashDelete($item['DashDashboardItem']['dashable_id']);
		else
			$return = $dashableModel->delete($item['DashDashboardItem']['dashable_id']);
		
		return $return;
	}
	
	//Removes from the dashboard table all the items that don't exist in the orignal model
	function synchronizeWithItems()
	{
		$items = $this->find('all');
		foreach($items as $item)
		{
			$model = ClassRegistry::init(array('class' => $item['DashboardItem']['dashable_model']));
			$dashable = $model->findById($item['DashboardItem']['dashable_id']);
			if(empty($dashable))
			{
				$this->remove($item);
			}
		}
	}
}

?>
