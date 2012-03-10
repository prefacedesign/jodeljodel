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
			'order' => 'modified DESC',
			'conditions' => array(
				'NOT' => array('name' => null)
			)
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
		
		$this->filter_and_search();
	}
	
	function render_table()
	{
		$this->filter_and_search();
		$this->render('filter');
	}
	
	function filter($module = null)
	{
		if ($this->Session->read('Dashboard.filter') == $module)
			$module = '';
		$this->Session->write('Dashboard.filter', $module);
		$this->render_table();
	}
	
	
	function filter_published_draft($status)
	{
		if ($this->Session->read('Dashboard.status') == $status)
			$status = '';
		$this->Session->write('Dashboard.status', $status);
		$this->render_table();
	}
	
	
	function search()
	{
		$conditions = array();
		if (!empty($this->data['dash_search']))
		{
			$conditions['OR'] = array();
			$conditions['OR'][] = array('name LIKE' => '%'.$this->data['dash_search'].'%');
			$conditions['OR'][] = array('info LIKE' => '%'.$this->data['dash_search'].'%');
		}
		
		$this->Session->write('Dashboard.searchOptions', $conditions);
		$this->render_table();
	}
	
	
	function filter_and_search()
	{
		$conditions = array();
		$c = $this->Session->read('Dashboard.searchOptions');
		if ($c)
			$conditions = $c;
		
		$filter_status = $this->Session->read('Dashboard.status');
		$filter = $this->Session->read('Dashboard.filter');
		
		if ($filter_status != 'all' && !empty($filter_status))
			$conditions['status'] = $filter_status;
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
		$this->set(compact('filter', 'filter_status'));
	}

/**
 * 
 * 
 * @access 
 */
	function delete_item($id)
	{
		$this->view = 'JjUtils.Json';
	
		$success = $this->DashDashboardItem->deleteItem($id);
		$this->set('jsonVars', compact('success'));
	}

/**
 * method description
 * 
 * @access public
 * @return type description
 */
	function synch($force_update = false)
	{
		$this->autoRender = false;
		$this->header('Content-Type: text/plain');
		
		$modules = Configure::read('jj.modules');
		
		foreach ($modules as $name => $module)
		{
			if (!isset($module['plugged']) || !in_array('dashboard', $module['plugged']))
				continue;

			echo 'Synching dashboard for ' . $name;
			echo "\n";

			$Model =& ClassRegistry::init($module['model']);
			if (!$Model->Behaviors->attached('DashDashboardable'))
			{
				echo "  {$module['model']} has not DashDashboardable behavior attached!\n";
				echo 'Synch failed';
				echo "\n";
			}
			else
			{
				extract($Model->synchronizeWithDashboard($force_update));
				echo "  Removed entries: " . count($childless);
				echo "\n";
				echo "  Updated entries: " . count($outdated);
				echo "\n";
				echo "  Created entries: " . count($doesnt_have);
				echo "\n";
				echo 'Synch done.';
				echo "\n";
			}

			echo "\n";
		}
		
	}
}
