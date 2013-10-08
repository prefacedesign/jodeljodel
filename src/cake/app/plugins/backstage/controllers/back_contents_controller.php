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
 * SOME FILE INFORMATIONS
 * 
 * @package
 * @subpackage
 */
 
App::import('Core','ModelBehavior');
App::import('Behavior','Status.Status');

/**
 * SOME CLASS INFORMATIONS
 * 
 * @package
 * @subpackage
 */
class BackContentsController extends BackstageAppController
{
/**
 * Name for this controller
 * 
 * @access public
 * @var string
 */
    var $name = 'BackContents';

/**
 * List of Models to load on construct. Defaults to none.
 * 
 * @access public
 * @var array
 */
    var $uses = array();
	var $helpers = array('Text');
	var $components = array('Session', 'RequestHandler');
	
	var $backstageModel;
	var $modules;
	var $backstageSettings;
	var $limit = 20;
	var $status = false;
	var $custom_filter = array();

/**
 * Before filter callback (loads configuration parameters)
 * 
 * @access public
 */
	function beforeFilter()
	{
		App::import('Config','Backstage.backstage');
		$this->modules = Configure::read('jj.modules');
		$this->backstageSettings = Configure::read('Backstage.itemSettings');

		parent::beforeFilter();
	}
	
/** 
 * Action to edit/create a model row. Model must have implemented
 * createEmpty (to create a new empty row) and. findBurocrata (to retrieve
 * the data needed for the form). The plugin must have
 * the element model_name with 'type' => array('burocrata','form').
 *
 * @access public
 * @param string $moduleName Module name, configured on bootstrap.php
 * @param mixed $id The id of the row to be edited. If "null" it means that a new will be created.
 */
	function edit($moduleName = false, $id = null)
	{
		$this->header('Cache-Control: no-cache, max-age=0, must-revalidate, no-store');

		if (empty($moduleName) || !($config = Configure::read('jj.modules.'.$moduleName)))
			$this->jodelError('Jodel module ' .$moduleName. ' not found.');

		list($contentPlugin, $modelName) = pluginSplit($config['model']);

		$fullModelName = $config['model'];
		$Model =& ClassRegistry::init($fullModelName);

        if (is_null($id))
        {
			if (isset($config['permissions']) && isset($config['permissions']['create']))
			{
				if (!$this->JjAuth->can($config['permissions']['create']))
				{
					$this->JjAuth->stop();
				}
			}
			
            if (method_exists($Model, 'createEmpty'))
			{
                if ($Model->createEmpty())
				{
                	if (empty($Model->id))
                		$this->jodelError('Your createEmpty method returned true, but the model doesn`t have an ID. Are you sure that createEmpty really created an database row?');

					$this->Session->write('Backstage.adding_record', true);
					$this->redirect(array($moduleName, $Model->id));
				}
				elseif (Configure::read())
				{
					$this->jodelError('Could not create an empty record.');
				}
			}
			else
			{
				$this->jodelError('Method '.$modelName.'::createEmpty() on '.$contentPlugin.' not found!');
			}
        }
        else
        {
            if (method_exists($Model, 'findBurocrata'))
                $this->data = $Model->findBurocrata($id);
            else
                $this->data = $Model->findById($id);
			
			$adding = $this->Session->read('Backstage.adding_record');
			$this->Session->delete('Backstage.adding_record');
			
			if ($adding)
			{
				if (isset($config['permissions']) && isset($config['permissions']['create']))
				{
					if (!$this->JjAuth->can($config['permissions']['create']))
						$this->JjAuth->stop();
				}
			}
			else
			{
				$canEdit = true;
				
				if (isset($config['additionalFilteringConditions']))
				{
					foreach($config['additionalFilteringConditions'] as $filterName)
					{
						if (App::import('Lib', $filterName))
						{
							list ($filterPlugin, $filterName) = pluginSplit($filterName);
							if (!$filterName::can($this, $this->data[$Model->alias]))
							{
								$canEdit = false;
							}
						}
					}
				}
				
				if (isset($config['permissions']) && ((isset($config['permissions']['edit_draft']) && isset($config['permissions']['edit_published'])) || isset($config['permissions']['edit'])))
				{
					if (isset($config['permissions']['edit_published']) && isset($this->data[$Model->alias]['publishing_status']) && $this->data[$Model->alias]['publishing_status'] == 'published')
					{	
						if (!$this->JjAuth->can($config['permissions']['edit_published']))
							$canEdit = false;
					}
					elseif (isset($config['permissions']['edit_draft']) && isset($this->data[$Model->alias]['publishing_status']) && $this->data[$Model->alias]['publishing_status'] == 'draft')
					{	
						if (!$this->JjAuth->can($config['permissions']['edit_draft']))
							$canEdit = false;
					}
					elseif (!isset($this->data[$Model->alias]['publishing_status']) && isset($config['permissions']['edit']))
					{
						if (!$this->JjAuth->can($config['permissions']['edit']))
							$canEdit = false;
					}
				}
				
				if (!$canEdit) $this->JjAuth->stop();
			}
        }
        if (isset($Model->Behaviors->TradTradutore->settings[$Model->alias]))
			$this->set('translateModel', Inflector::camelize($Model->Behaviors->TradTradutore->settings[$Model->alias]['className']));
		$this->set(compact('contentPlugin', 'modelName', 'fullModelName', 'moduleName'));
    }
	
	private function __getOptions($moduleName)
	{
		$this->backstageModel = ClassRegistry::init(array('class' =>  $this->modules[$moduleName]['model']));
		
		$defaultOptions = array();
		$this->status = $this->Session->read("Backstage.{$moduleName}.status");
		if ($this->status != 'all' && !empty($this->status))
			$defaultOptions['conditions'][$this->backstageModel->alias.'.publishing_status'] = $this->status;
		
		if (isset($this->backstageSettings[$moduleName]['customFilters']))
		{
			foreach($this->backstageSettings[$moduleName]['customFilters'] as $customFilter)
			{
				$fieldName = $customFilter['fieldName'];
				$fieldValue = $this->Session->read("Backstage.{$fieldName}.{$moduleName}.status");
				if ($fieldValue != 'all' && !empty($fieldValue))
					$defaultOptions['conditions'][$fieldName] = $fieldValue;
				
				$this->custom_filter[$fieldName] = $fieldValue;
			}
		}
		
		if (isset($this->backstageSettings[$moduleName]['limitSize']))
			$defaultOptions['limit'] = $this->backstageSettings[$moduleName]['limitSize'];
		else
			$defaultOptions['limit'] = $this->limit;
		if (isset($this->backstageSettings[$moduleName]['contain']))
			$defaultOptions['contain'] = $this->backstageSettings[$moduleName]['contain'];
		if (isset($this->backstageModel->Behaviors->TempTemp->__settings))
			$defaultOptions['conditions'][$this->backstageModel->alias.'.'.$this->backstageModel->Behaviors->TempTemp->__settings[$this->backstageModel->alias]['field']] = 0;
		
		$options = array();
		
		//get first options to filter backstage table, if paramsFoward is set in config
		if (isset($this->backstageSettings[$moduleName]['paramsFoward']))
		{
			if (method_exists($this->backstageModel, 'getBackstageListData'))
				$options = $this->backstageModel->getBackstageListData($this->__getParams($moduleName));
			else
				trigger_error('BackContentsController::index - getBackstageListData action not exists in '.$this->backstageModel->alias.'. This action should exists to paramsFoward parameter in backstage config') and die;
		}	
		//get header data to backstage table, if customHeader is set in config
		if (isset($this->backstageSettings[$moduleName]['customHeader']))
		{
			$headerData = array();
			if (method_exists($this->backstageModel, 'getBackstageHeaderData'))
				$headerData = $this->backstageModel->getBackstageHeaderData($this->__getParams($moduleName));
			$this->set('headerData', $headerData);
		}
		
		$op = $this->Session->read('Backstage.searchOptions') ?: array();		
		$options = array_merge_recursive($options, $op, $defaultOptions);
		if (isset($this->modules[$moduleName]['additionalFilteringConditions']))
		{
			if (!isset($options['conditions']))
			{
				$options['conditions'] = array();
			}
			
			foreach ($this->modules[$moduleName]['additionalFilteringConditions'] as $filterName)
			{
				if (App::import('Lib', $filterName))
				{
					list ($filterPlugin, $filterName) = pluginSplit($filterName);
					$options['conditions'] = $filterName::getPermissionConditions($this, $options['conditions']);
				}
			}
		}
		
		return $options;
	}
	
	private function __getParams($moduleName)
	{
		$params = array();
		foreach ($this->backstageSettings[$moduleName]['paramsFoward'] as $key => $param)
		{
			$params[$param] = isset($this->params['pass'][$key+1]) ? $this->params['pass'][$key+1] : '';
		}
		
		return $params;
	}
	
	
	function index($moduleName)
	{
		$this->TradLanguageSelector->setLanguage(Configure::read('Tradutore.mainLanguage'));
		$this->header('Cache-Control: no-cache, max-age=0, must-revalidate, no-store');
		
		$conditions = array();
		if (!isset($this->modules[$moduleName]))
			trigger_error('BackContentsController::index - '.$moduleName.' not found in jj.modules') and die;
		elseif (!isset($this->modules[$moduleName]['model']))
			trigger_error('BackContentsController::index - '.$moduleName.'[`model`] not found in jj.modules') and die;
		else
		{
			if (!in_array('backstage_custom',$this->modules[$moduleName]['plugged'])) 
				trigger_error('BackContentsController::index - '.$moduleName.' configured in jj.modules must have `backstage_custom` in plugged options') and die;
			else
			{
				if (!isset($this->backstageSettings[$moduleName]))
					trigger_error('BackContentsController::index - '.$moduleName.' configurations not found on backstage config') and die;
				else
				{
					if (!isset($this->params['named']['page']))
					{
						$this->Session->write('Backstage.searchOptions', array());
					}
					else
					{
						$page = $this->params['named']['page'];
					}
						
					$options = $this->__getOptions($moduleName);
					
					if (isset($page))
						$options['page'] = $page;
					
					$this->paginate = array($this->backstageModel->alias => $options);
					
					$this->set('backstageSettings', $this->backstageSettings[$moduleName]);
					$this->set('moduleName', $moduleName);
					$this->set('modelName', $this->backstageModel->alias);
					$this->set('filter_status', $this->status);
					$this->set('custom_filter', $this->custom_filter);
					$this->data = $this->paginate($this->backstageModel);
					$this->helpers['Paginator'] = array('ajax' => 'Ajax');
					
					$config = $this->modules[$moduleName];
					if (isset($config['additionalFilteringConditions']))
					{
						$canView = true;
						foreach($config['additionalFilteringConditions'] as $filterName)
						{
							if (App::import('Lib', $filterName))
							{
								list ($filterPlugin, $filterName) = pluginSplit($filterName);
								if (!$filterName::can($this, $this->data))
								{
									$canView = false;
								}
							}
						}
						if (!$canView)
						{
							$this->JjAuth->stop();
						}
					}
					elseif (isset($config['permissions']) && isset($config['permissions']['view']))
					{
						if (!$this->JjAuth->can($config['permissions']['view']))
						{
							$this->JjAuth->stop();
						}
					}

					if($this->RequestHandler->isAjax())
					{
						$this->render('filter');
					}
				}
			}
		}
	}
	
	function filter_published_draft($status, $moduleName)
	{
		$this->Session->write("Backstage.{$moduleName}.status", $status);
		$this->filter_and_search($moduleName);
	}
	
	function filter_custom($fieldName, $status, $moduleName)
	{
		$this->Session->write("Backstage.{$fieldName}.{$moduleName}.status", $status);
		$this->filter_and_search($moduleName);
	}
	
	function after_delete($moduleName)
	{
		$this->index($moduleName);
	}
	
	function search($moduleName)
	{		
		$this->backstageModel = ClassRegistry::init(array('class' =>  $this->modules[$moduleName]['model']));
		
		if (method_exists($this->backstageModel, 'getBackstageFindOptions'))
		{	
			$options = $this->backstageModel->getBackstageFindOptions($this->data);
			if (!is_array($options))
			{
				$this->jodelError('BackContentsController::search - options must be an array');
			}
			else
			{
				$this->Session->write('Backstage.searchOptions', $options);
				$this->filter_and_search($moduleName);
			}
		}
		else
		{	
			if (!empty($this->data['dash_search']))
			{	
				$conditions['OR'] = array();
				foreach($this->backstageSettings[$moduleName]['columns'] as $col)
					$conditions['OR'][] = array($col['field'] . ' LIKE' => '%'.$this->data['dash_search'].'%');
				$options = array('conditions' => $conditions);
			}
			else
				$options = array();
			
			$this->Session->write('Backstage.searchOptions', $options);
			$this->filter_and_search($moduleName);
		}
	}
	
	
	function filter_and_search($moduleName)
	{
		$options = $this->__getOptions($moduleName);
		$this->paginate = array($this->backstageModel->alias => $options);
			
		//test to emulate paginate (possible to implement in future, with findBackstage)
		/*
		$count = $this->backstageModel->find('count', array('contain' => false, 'order' => 'modified DESC', 'conditions' => $conditions));
		$this->data = $this->backstageModel->find('all', array('limit' => $limit, 'page' => 1, 'contain' => false, 'order' => 'modified DESC', 'conditions' => $conditions));
		$page = 1;
		$pageCount = intval(ceil($count / $limit));
		$options['limit'] = $limit;
		
		$paging = array(
			'page' => $page,
			'current' => count($this->data),
			'count' => $count,
			'prevPage' => ($page > 1),
			'nextPage' => ($count > ($page * $limit)),
			'pageCount' => $pageCount,
			'defaults' => array('limit' => $limit, 'step' => 1),
			'options' => $options
		);
		$this->params['paging'][$this->backstageModel->alias] = $paging;
		*/
		
		$this->data = $this->paginate($this->backstageModel);
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		$this->set('backstageSettings', $this->backstageSettings[$moduleName]);
		$this->set('moduleName', $moduleName);
		$this->set('modelName', $this->backstageModel->alias);
		$this->layout = 'ajax';
		$this->render('filter', 'ajax');
	}
	
	function delete_item($moduleName, $id)
	{
		$this->view = 'JjUtils.Json';
		$this->backstageModel = ClassRegistry::init(array('class' =>  $this->modules[$moduleName]['model']));
		
		if (method_exists($this->backstageModel, 'backDelete'))
			$return = $this->backstageModel->backDelete($id);
		else
			$return = $this->backstageModel->delete($id);
		
		
		if ($return)
			$this->set('jsonVars', array('success' => true));
		else
			$this->set('jsonVars', array('success' => false));
	}
	
/** 
 * To change the publishing status of a content. This action returns
 * a JSON, with {"sucess":true} if the status change has success.
 *
 * @access public
 * @param string $moduleName Module name, configured on bootstrap.php
 * @param string $id The id of the row to set a new status to.
 * @param string $status The status that can be either 'draft' or 'published'.
 * @param string $language The language being edited. If language is passed it will change only the status of translation.
 */
	function set_publishing_status($moduleName = false, $id = false, $status = false, $language = null)
	{
		if (empty($moduleName) || empty($id) || empty($status))
			$this->cakeError('error404');
		
		if (!($config = Configure::read('jj.modules.'.$moduleName)))
			$this->cakeError('error404');
		
		list($contentPlugin, $modelName) = pluginSplit($config['model']);
		
		$fullModelName = $config['model'];
		$Model =& ClassRegistry::init($fullModelName);
		
		if ($language)
			if (isset($Model->Behaviors->TradTradutore->settings[$Model->alias]))
				$Model =& ClassRegistry::init($contentPlugin.'.'.$Model->Behaviors->TradTradutore->settings[$Model->alias]['className']);
		
		
		if ($Model->setStatus($id, array('publishing_status' => $status)))
			$this->set('jsonVars', array('success' => true));
		else
			$this->set('jsonVars', array('success' => false));
		
		$this->view = 'JjUtils.Json';
	}
	
	
/** 
 * To create a empty translation register. This action calls
 * a createEmptytranlation method of TradTradutore Behavior
 *
 * @access public
 * @param string $moduleName Module name, configured on bootstrap.php
 * @param string $id The id of the row to set a new status to.
 */
	function create_empty_translation($moduleName, $id = null)
	{
		if (empty($moduleName) || !($config = Configure::read('jj.modules.'.$moduleName)))
			$this->jodelError('Jodel module ' .$moduleName. ' not found.');
		
		$Model =& ClassRegistry::init($config['model']);
		if (!$Model->createEmptyTranslation($id, $this->params['language']))
		{
			list($contentPlugin,$modelName) = pluginSplit($config['model']);
			$this->jodelError('Method '.$modelName.'::createEmptyTranslation() (TradTradutoreBehavior method) could not create an empty translation!');
		}
			
		$this->redirect(array('language' => $this->params['language'], 'action' => 'edit', $moduleName, $id));
	}
	
	function layout_test()
	{
		$this->loadModel('CsTest');
		$data = $this->CsTest->findById(1);
		if (empty($data))
		{
			$data = $this->CsTest->save(array('id' => 1));
		}
		$this->data = $data;
	}
}
