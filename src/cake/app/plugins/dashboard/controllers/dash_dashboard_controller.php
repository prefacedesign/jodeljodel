<?php
/*
 *
 */
 
App::import('Config','Dashboard.config');
define ('LIMIT', Configure::read('Dashboard.limitSize'));

/**
 * 
 * 
 */
class DashDashboardController extends DashboardAppController
{
	var $name = 'DashDashboard';
	var $uses = array('Dashboard.DashDashboardItem');
	var $paginate = array(
		'DashDashboardItem' => array(
			'limit' => LIMIT,
			'contain' => false,
			'order' => 'modified DESC'
		)
	);
	var $components = array('Session', 'RequestHandler');
	var $helpers = array('Text');



/**
 * This is the actual dashboard page.
 * 
 * @todo Enable to select the page where a certain id is located.
 */
	function index()
	{
		
		$this->set('itemSettings', Configure::read('Dashboard.itemSettings'));
		$this->set('statusOptions', Configure::read('Dashboard.statusOptions'));
		
		$conditions = array();
		$status = $this->Session->read('filter_status');
		$filter = $this->Session->read('filter');
		if ($status != 'all' && !empty($status))
			$conditions['status'] = $status;
		if ($filter != 'all' && !empty($filter))
			$conditions['type'] = $filter;
		
		$this->paginate = array(
			'DashDashboardItem' => array(
				'limit' => LIMIT,
				'contain' => false,
				'order' => 'modified DESC',
				'conditions' => $conditions
			)
		);
		$this->set('filter', $filter);
		$this->set('filter_status', $status);
		$this->data = $this->paginate('DashDashboardItem');
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		
		if($this->RequestHandler->isAjax()) {
            $this->render('filter');            
        } 

	}
	
	function filter($module)
	{
		$conditions = array();
		$status = $this->Session->read('filter_status');
		if ($status != 'all' && !empty($status))
			$conditions['status'] = $status;
		if ($module != 'all')
			$conditions['type'] = $module;
			
		
		$this->paginate = array(
			'DashDashboardItem' => array(
				'limit' => LIMIT,
				'contain' => false,
				'order' => 'modified DESC',
				'conditions' => $conditions
			)
		);
			
		$this->Session->write('filter', $module);
		$this->data = $this->paginate('DashDashboardItem');
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		$this->set('itemSettings', Configure::read('Dashboard.itemSettings'));
		$this->layout = 'ajax';
	}
	
	
	function filter_published_draft($status)
	{
		$conditions = array();
		$filter = $this->Session->read('filter');
		if ($filter != 'all' && !empty($filter))
			$conditions['type'] = $filter;
		if ($status != 'all')
			$conditions['status'] = $status;
		
		$this->paginate = array(
			'DashDashboardItem' => array(
				'limit' => LIMIT,
				'contain' => false,
				'order' => 'modified DESC',
				'conditions' => $conditions
			)
		);
		$this->Session->write('filter_status', $status);
		$this->data = $this->paginate('DashDashboardItem');
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		$this->set('itemSettings', Configure::read('Dashboard.itemSettings'));
		$this->render('filter', 'ajax');
	}


/**
 * 
 * 
 * @access 
 */
	function delete_item($id)
	{
		$this->view = 'JjUtils.Json';
	
		if ($this->DashDashboardItem->deleteItem($id))
			$this->set('jsonVars', array('success' => true));
		else
			$this->set('jsonVars', array('success' => false));
	}
}
