<?php
/**
 * SOME FILE INFORMATIONS
 * 
 * @package
 * @subpackage
 */
 
App::import('Core','ModelBehavior');
App::import('Behavior','Status.Status');
App::import('Config','Backstage.backstage');

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
	
	function __construct()
	{
		parent::__construct();
		$this->modules = Configure::read('jj.modules');
		$this->backstageSettings = Configure::read('Backstage.itemSettings');
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
		if (empty($moduleName) || !($config = Configure::read('jj.modules.'.$moduleName)))
			$this->cakeError('error404');
		
		list($contentPlugin, $modelName) = pluginSplit($config['model']);
		
        $fullModelName = $config['model'];
        $Model =& ClassRegistry::init($fullModelName);
        
        if (is_null($id))
        {
            if (method_exists($Model, 'createEmpty'))
			{
                if ($Model->createEmpty())
					$this->redirect(array($moduleName, $Model->id));
				elseif (Configure::read())
					trigger_error('Could not create an empty record.') and die;
			}
			else
			{
				trigger_error('Method '.$modelName.'::createEmpty() on '.$contentPlugin.' not found!') and die;
			}
        }
        else
        {
            if (method_exists($Model, 'findBurocrata'))
                $this->data = $Model->findBurocrata($id);
            else
                $this->data = $Model->findById($id);
				
        }
        
		$this->set(compact('contentPlugin', 'modelName', 'fullModelName', 'moduleName'));
    }
	
	function index($moduleName, $page = null)
	{
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
					if (isset($this->params['named']['page']))
						$this->Session->write('Backstage.page', $this->params['named']['page']);
					else
						$this->Session->write('Backstage.page', 0);
						
					if (isset($this->params['named']['page']))
					{
						$c = $this->Session->read('Backstage.searchOptions');
						if ($c)
							$conditions = $c;
						else
							$conditions = array();
					}
					else
						$this->Session->write('Backstage.searchOptions', array());
					
					$limit = isset($this->backstageSettings[$moduleName]['limitSize']) ? $this->backstageSettings[$moduleName]['limitSize'] : 20;
					$this->backstageModel = ClassRegistry::init(array('class' =>  $this->modules[$moduleName]['model']));

					if (isset($this->backstageModel->Behaviors->TempTemp->__settings))
						$conditions[$this->backstageModel->alias.'.'.$this->backstageModel->Behaviors->TempTemp->__settings[$this->backstageModel->alias]['field']] = 0;
						
					$status = $this->Session->read('Backstage.status');
					if ($status != 'all' && !empty($status))
						$conditions['publishing_status'] = $status;
					
					
					if ($page)
					{
						$this->paginate = array(
							$this->backstageModel->alias => array(
								'limit' => $limit,
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
							$this->backstageModel->alias => array(
								'limit' => $limit,
								'contain' => false,
								'order' => 'modified DESC',
								'conditions' => $conditions
							)
						);
					}
					
					$this->set('backstageSettings', $this->backstageSettings[$moduleName]);
					$this->set('moduleName', $moduleName);
					$this->set('modelName', $this->backstageModel->alias);
					$this->set('filter_status', $status);
					$this->data = $this->paginate($this->backstageModel);
					$this->helpers['Paginator'] = array('ajax' => 'Ajax');
					
					if($this->RequestHandler->isAjax()) {
						$this->render('filter');            
					}
				}
			}
		}
	}
	
	function filter_published_draft($status, $moduleName)
	{
		$this->Session->write('Backstage.status', $status);
		$this->filter_and_search($moduleName);
	}
	
	function after_delete($moduleName)
	{
		$page = $this->Session->read('page');
		$this->index($moduleName, $page);
	}
	
	function search($moduleName)
	{
		$this->backstageModel = ClassRegistry::init(array('class' =>  $this->modules[$moduleName]['model']));
		
		if (method_exists($this->backstageModel, 'findBackstage'))
		{	
			$conditions = $this->backstageModel->findBackstage($this->data['dash_search']);
			if (!is_array($conditions))
				trigger_error('BackContentsController::search - conditions must be an array') and die;
			if (isset($conditions['conditions']))
			{
				$conditions = $conditions['conditions'];
				unset($conditions['conditions']);
			}
			$this->Session->write('Backstage.searchOptions', $conditions);
			$this->filter_and_search($moduleName);
		}
		else
		{	
			if (!empty($this->data['dash_search']))
			{
				$conditions['OR'] = array();
				foreach($this->backstageSettings['columns'] as $col)
					$conditions['OR'][] = array($col['field'] . ' LIKE' => '%'.$this->data['dash_search'].'%');
			}
			else
				$conditions = array();
			
			$this->Session->write('Backstage.searchOptions', $conditions);
			$this->filter_and_search($moduleName);
		}
	}
	
	
	function filter_and_search($moduleName)
	{
		$c = $this->Session->read('Backstage.searchOptions');
		if ($c)
			$conditions = $c;
		else
			$conditions = array();
		
		$status = $this->Session->read('Backstage.status');
		if ($status != 'all' && !empty($status))
			$conditions['publishing_status'] = $status;
		
		$this->backstageModel = ClassRegistry::init(array('class' =>  $this->modules[$moduleName]['model']));
		$limit = isset($this->backstageSettings[$moduleName]['limitSize']) ? $this->backstageSettings[$moduleName]['limitSize'] : 20;
		
		if (isset($this->backstageModel->Behaviors->TempTemp->__settings))
			$conditions[$this->backstageModel->alias.'.'.$this->backstageModel->Behaviors->TempTemp->__settings[$this->backstageModel->alias]['field']] = 0;
			
		$this->paginate = array(
			$this->backstageModel->alias => array(
				'limit' => $limit,
				'contain' => false,
				'order' => 'modified DESC',
				'conditions' => $conditions
			)
		);
			
		
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
 */
	function set_publishing_status($moduleName = false, $id = false, $status = false)
	{
		if (empty($moduleName) || empty($id) || empty($status))
			$this->cakeError('error404');
		
		if (!($config = Configure::read('jj.modules.'.$moduleName)))
			$this->cakeError('error404');
		
		list($contentPlugin, $modelName) = pluginSplit($config['model']);
		
		$fullModelName = $config['model'];
		$Model =& ClassRegistry::init($fullModelName);
		
		if ($Model->setStatus($id, array('publishing_status' => $status)))
			$this->set('jsonVars', array('success' => true));
		else
			$this->set('jsonVars', array('success' => false));
		
		$this->view = 'JjUtils.Json';
	}
}