<?php

	class DashDashboardController extends AppController
	{
		var $uses = null;
		function admin_index()
		{
			$model = ClassRegistry::init(array('class' => 'Dashboard.DashDashboardItem'));
			$this->set('items', $model->find('all'));
		}
		
		/*
			Removes an item from the dashboard
			@param id			the id of the item in the original model
			@param model		the alias of the original model
		*/
		function admin_removeDashboardItem($id, $modelName) 
		{
			$dashboard = ClassRegistry::init(array('class' => 'Dashboard.DashDashboardItem'));
			$dashboard->removeDashItem($id, true);
			
			$this->redirect(array('action'=>'index'));
		}
	}
	
?>