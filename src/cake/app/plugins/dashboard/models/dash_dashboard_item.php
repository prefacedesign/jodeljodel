<?php
	/*
	 * @todo Revamp data structure.
	 * @todo Introduce tag copying.
	 * @todo Use loadModel instead of ClassRegistry.
	 * @todo Use only 'type' => 'person' instead of storing the name of the Cake Models'
	 */
	
	/*
	 * A model for the dash_dashboard_items table
	 * Each DashDashboardItem is a summary of a dashable Model
	*/
	class DashDashboardItem extends AppModel
	{
		var $name = 'DashDashboardItem';
		
		/*
		Inserts or updates one item in the dashboard
		@param data 						The default array that describes the dash_dashboard_items table
		@param updateDashable		if true, updates the original model table, otherwise only updates the dashboard table
													This parameter is used to prevend infinite loops
		@todo This function doesn't make any sense.
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
		Deletes an item from the dashboard and
		@param id 	The dashboard_item id  ('Modelname@ID.     ex: 'Event@32)
		@param updateDashable if true, updates the original model table, otherwise only updates the dashboard table
													This parameter is used to prevend infinite loops
		@todo Analyze wheter this function is deprecated.
		*/
		function removeDashItem($id, $updateDashable = false)
		{
			$this->delete($id);
			
			if($updateDashable)
			{
				$data = explode('@', $id);
				$model = $data[0]; //@todo 
				$id = $data[1];
				$dashableModel =  ClassRegistry::init(array('class' =>  $model));
				$dashableModel->delete($id);
			}
		}
		
		/** deleteItem($id)
		 *  Deletes a item from the table, by deleting the original item. As everything 
		 *  is synchronized it should also delete the Dashboard entry.
		 *
		 *  @param $id The item's id in dashboard.
		 *	@return boolean True if succesful, false if otherwise.
		 */
		function deleteItem($id)
		{
			$item = $this->find('first', array(
				'conditions' => array('id' => $id),
				'fields' => array('DashDashboardItem.dashable_id', 'DashDashboardItem.type')
			));
			
			$module = Configure::read('jj.modules.' . $item['DashDashboardItem']['type']);	
			$dashableModel = ClassRegistry::init(Inflector::camelize($module['plugin']).'.'.$module['model'],'Model');
			return $dashableModel->dashDelete($item['DashDashboardItem']['dashable_id']);
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