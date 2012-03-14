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
	var $uses = array('Dashboard.DashDashboardItem', 'MexcSpace.MexcSpace');
	var $paginate = array(
		'DashDashboardItem' => array(
			'limit' => LIMIT,
			'contain' => false,
			'order' => 'modified DESC',
			'conditions' => array(
				'NOT' => array('DashDashboardItem.name' => null)
			)
		)
	);
	var $components = array('Session', 'RequestHandler');
	var $helpers = array('Text');


	function beforeFilter()
	{
		parent::beforeFilter();
		$this->set('spaces', $this->MexcSpace->find('all', array('conditions' => array('parent_id IS NULL'))));
	}

/**
 * This is the actual dashboard page.
 * 
 * @todo Enable to select the page where a certain id is located.
 */
	function index()
	{
		if (isset($this->params['named']['page']))
			$this->Session->write('Dashboard.page', $this->params['named']['page']);
		else
			$this->Session->write('Dashboard.page', 0);
		
		$this->set('itemSettings', Configure::read('Dashboard.itemSettings'));
		$this->set('statusOptions', Configure::read('Dashboard.statusOptions'));
		
		$this->filter_and_search();
	}
	
	function render_table()
	{
		$page = $this->Session->read('Dashboard.page');
		$this->filter_and_search($page);
		$this->render('filter');
	}
	
	function filter($module = null)
	{
		if ($this->Session->read('Dashboard.filter') == $module)
			$module = '';
		$this->Session->write('Dashboard.filter', $module);
		$this->render_table();
	}
	
	function filter_space($space = null)
	{
		$this->Session->write('Dashboard.space', $space);
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
			$conditions['OR'][] = array('DashDashboardItem.name LIKE' => '%'.$this->data['dash_search'].'%');
			$conditions['OR'][] = array('DashDashboardItem.info LIKE' => '%'.$this->data['dash_search'].'%');
		}
		
		$this->Session->write('Dashboard.searchQuery', $this->data['dash_search']);
		$this->Session->write('Dashboard.searchOptions', $conditions);
		$this->render_table();
	}
	
	
	function filter_and_search($page = null)
	{
		$conditions = array();
		$c = $this->Session->read('Dashboard.searchOptions');
		if ($c)
			$conditions = $c;
		
		$filter_status = $this->Session->read('Dashboard.status');
		$filter_space = $this->Session->read('Dashboard.space');
		$filter = $this->Session->read('Dashboard.filter');
		
		if ($filter_status != 'all' && !empty($filter_status))
			$conditions['status'] = $filter_status;
		if ($filter_space != 'all' && !empty($filter_space))
		{
			$conds = $this->MexcSpace->getConditionsForSpaceFiltering($filter_space);
			$conditions['mexc_space_id'] =  $conds['mexc_space_id'];
		}
		if ($filter != 'all' && !empty($filter))
			$conditions['type'] = $filter;		
			
		$this->paginate = array(
			'DashDashboardItem' => array(
				'limit' => LIMIT,
				'contain' => false,
				'order' => 'modified DESC',
				'conditions' => $conditions,
				'page' => isset($page) ? $page : 0
			)
		);
		$this->data = $this->paginate('DashDashboardItem');
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		$this->set('itemSettings', Configure::read('Dashboard.itemSettings'));
		$this->set('searchQuery', $this->Session->read('Dashboard.searchQuery'));
		$this->set(compact('filter', 'filter_status', 'filter_space'));
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
