<?php
	/*
	 *
	 */
	 
	App::import('Config','DashDashboard.config');

	class DashDashboardController extends DashboardAppController
	{
		var $name = 'DashDashboard';
		var $uses = array('Dashboard.DashDashboardItem');
		var $paginate = array(
			'DashDashboardItem' => array(
				'limit' => 20,
				'contain' => false,
				'order' => 'modified DESC'
			)
		);
		var $helpers = array('Text','Popup.Popup');
		
		/* This is the actual dashboard page.
		 * 
		 * @todo Enable to select the page where a certain id is located.
		 */
		
		function index()
		{
			$this->data = $this->paginate('DashDashboardItem');
			$this->set('itemSettings', Configure::read('Dashboard.item_settings'));
		}
		
		function delete_item($id)
		{
			$this->view = 'Burocrata.Json';
		
			if ($this->DashDashboardItem->deleteItem($id))
				$this->set('jsonVars', array('success' => true));
			else
				$this->set('jsonVars', array('success' => false));
		}
	}
	
?>