<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

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
			'contain' => false,
			'order' => 'modified DESC',
			'conditions' => array(
				'NOT' => array('DashDashboardItem.name' => null)
			)
		)
	);
	var $components = array('Session', 'RequestHandler');
	var $helpers = array('Text');

/**
 * Before filter callback: loads the plugin configuration parameters
 * 
 * @access public
 */
	function beforeFilter()
	{
		Configure::load('Dashboard.dash');
		parent::beforeFilter();
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
		if ($this->Session->check('Dashboard.searchOptions'))
			$conditions = $this->Session->read('Dashboard.searchOptions');
		
		$filter_status = $this->Session->read('Dashboard.status');
		if ($filter_status != 'all' && !empty($filter_status))
		{
			$conditions['status'] = $filter_status;
		}
		
		$filter = $this->Session->read('Dashboard.filter');
		if ($filter != 'all' && !empty($filter))
		{
			$conditions['type'] = $filter;
		}

		// Get permission conditions from the modules and its configurations
		$allowedModules = array();
		$modules = Configure::read('jj.modules');
		foreach ($modules as $moduleName => $moduleConfig)
		{
			$plugged = isset($moduleConfig['plugged']) && in_array('dashboard', $moduleConfig['plugged']);
			if ($plugged && isset($moduleConfig['permissions']['view']) && $this->JjAuth->can($moduleConfig['permissions']['view']))
			{
				$allowedModules[] = $moduleName;
			}
		}
		
		if (!empty($allowedModules))
		{
			if (empty($conditions['type']) || !in_array($conditions['type'], $allowedModules))
			{
				$conditions['type'] = $allowedModules;
			}
		}

		// Get permission conditions from the additionalFilteringConditions configuration
		$additionalFilter = Configure::read('Dashboard.additionalFilteringConditions');
		if (!empty($additionalFilter))
		{
			foreach ($additionalFilter as $filterName)
			{
				if (App::import('Lib', $filterName))
				{
					list ($filterPlugin, $filterName) = pluginSplit($filterName);
					$conditions = $filterName::getPermissionConditions($this, $conditions);
				}
			}
		}
		
		$this->paginate = array(
			'DashDashboardItem' => array(
				'limit' => Configure::read('Dashboard.limitSize'),
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
		$this->set(compact('filter', 'filter_status'));
	}

/**
 * 
 * 
 * @access 
 */
	function delete_item($id, $module)
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
