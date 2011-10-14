<?php
/*
 *
 */
 
App::import('Config','Dashboard.dash');
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
	function index($page = null)
	{
		
		$this->set('itemSettings', Configure::read('Dashboard.itemSettings'));
		$this->set('statusOptions', Configure::read('Dashboard.statusOptions'));
		
		if (isset($this->params['named']['page']))
			$this->Session->write('page', $this->params['named']['page']);
		else
			$this->Session->write('page', 0);
		
		$conditions = array();
		if (isset($this->params['named']['page']))
		{
			$c = $this->Session->read('search_options');
			if ($c)
				$conditions = $c;
			else
				$conditions = array();
		}
		else
			$this->Session->write('search_options', array());
		$status = $this->Session->read('filter_status');
		$filter = $this->Session->read('filter');
		if ($status != 'all' && !empty($status))
			$conditions['status'] = $status;
		if ($filter != 'all' && !empty($filter))
			$conditions['type'] = $filter;
		
		if ($page)
		{
			$this->paginate = array(
				'DashDashboardItem' => array(
					'limit' => LIMIT,
					'page' => $page,
					'contain' => false,
					'order' => 'modified DESC',
					'conditions' => $conditions
				)
			);
		}
		else
		{
			$this->paginate = array(
				'DashDashboardItem' => array(
					'limit' => LIMIT,
					'contain' => false,
					'order' => 'modified DESC',
					'conditions' => $conditions
				)
			);
		}
		$this->set('filter', $filter);
		$this->set('filter_status', $status);
		$this->data = $this->paginate('DashDashboardItem');
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		
		if($this->RequestHandler->isAjax()) {
            $this->render('filter');            
        } 

	}
	
	function after_delete()
	{
		$page = $this->Session->read('page');
		$this->index($page);
	}
	
	function filter($module)
	{
		$c = $this->Session->read('search_options');
		if ($c)
			$conditions = $c;
		else
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
		$c = $this->Session->read('search_options');
		if ($c)
			$conditions = $c;
		else
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
	
	
	function search()
	{
		if (!empty($this->data['dash_search']))
		{
			$conditions['OR'] = array();
			$conditions['OR'][] = array('name LIKE' => '%'.$this->data['dash_search'].'%');
			$conditions['OR'][] = array('info LIKE' => '%'.$this->data['dash_search'].'%');
		}
		else
			$conditions = array();
		
		$this->Session->write('search_options', $conditions);
		
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
		

		$this->data = $this->paginate('DashDashboardItem');
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		$this->set('itemSettings', Configure::read('Dashboard.itemSettings'));
		$this->layout = 'ajax';
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
