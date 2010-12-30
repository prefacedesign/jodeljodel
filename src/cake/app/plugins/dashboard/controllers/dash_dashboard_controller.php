<?php
	/*
	 *
	 */

	class DashDashboardController extends DashboardAppController
	{
		var $name = 'DashDashboard';
		var $uses = array('Dashboard.DashDashboardItem');
		var $paginate = array(
			'DashDashboardItem' => array(
				'limit' => 30,
				'contain' => false,
				'order' => 'DashDashboardItem.modified DESC'
			)
		);
		
		/* This is the actual dashboard page.
		 * 
		 * @todo Enable to select the page where a certain id is located.
		 */
		
		function index()
		{
			$this->data = $this->paginate('DashDashboardItem');
		}
		
		function deleteItem($id)
		{
			
		}
	}
	
?>