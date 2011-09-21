<?php

/**
 * Controller for burocrata plugin.
 *
 * PHP versions 5
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.controllers
 */

/**
 * BuroBurocrataController.
 *
 * All burocrata`s ajax requests points here by default.
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.controllers
 */
class BuroBurocrataController extends BurocrataAppController
{

/**
 * The controller name
 *
 * @var string
 * @access public
 */
	public $name = 'BuroBurocrata';


/**
 * List of components
 *
 * @var array
 * @access public
 */
	public $components = array('Typographer.TypeLayoutSchemePicker', 'Burocrata.BuroBurocrata', 'RequestHandler');


/**
 * List of Models to be loaded on construct
 *
 * @var array
 * @access public
 */
	public $uses = array();


/**
 * Default View object to use
 *
 * @var string
 * @access public
 */
	public $view = 'JjUtils.Json';


/**
 * Name of the current model
 *
 * @var string
 * @access public
 */
	public $model_name = null;


/**
 * Plugin of the current model
 *
 * @var string
 * @access public
 */
	public $model_plugin = null;


/**
 * Current layout scheme
 *
 * @var string
 * @access public
 */
	public $layout_scheme = null;


/**
 * Holds some POSTed data (filled by BuroBurocrataComponent)
 *
 * @var array
 * @access public
 */
	public $buroData = array();


/**
 * beforeFilter callback
 * For while, it allows everyone to have access even if AuthComponent is set.
 * 
 * @access public
 * @todo Better user filtering
 */
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('*');
		
		StatusBehavior::setGlobalActiveStatuses(array('publishing_status' => array('active' => array('published','draft'), 'overwrite' => false)));
	}


/**
 * Attempts to save the data POSTed 
 * The JSON object returned has 3 attributes:
 * - `error` - is false when everyting went ok, or an frindly string describing the error
 * - `saved` - is false when couldn't saved the data, or the ID of the new entry on database
 * - `content` - The form
 * 
 * @access public
 * @return json An javascript object that contains `error`, `content` and `saved` properties
 */
	public function save()
	{
		$saved = false;
		$Model = null;
		$error = $this->BuroBurocrata->loadPostedModel($this, $Model);
		
		if($error === false)
		{
			$methodName = $this->BuroBurocrata->getSaveMethod($this, $Model);
			$saved = $Model->{$methodName}($this->data) !== false;
			
			if($saved)
			{
				$this->buroData['id'] = $saved = $Model->id;
				$this->view();
			}
		}
		
		$this->set(compact('saved', 'error'));
	}


/**
 * Just a router based on POSTed data (if it has POSTed data, it routers to 
 * save, if doesnt, routers to view.
 * 
 * @access public
 */
	public function edit()
	{
		if(isset($this->buroData['id']))
			$this->view();
		else
			$this->save();
		
		$this->render('save');
	}


/**
 * Return a JSON object containing an already rendered and populated element
 *
 * @access public
 * @return json An javascript object that contains `error` and `content` properties
 */
	public function view()
	{
		$data = $this->BuroBurocrata->getViewData($this);
		$this->data = $data['data'];
		$this->set($data);
	}


/**
 * Return a list to fill the autocomplete field.
 *
 * @access public
 * @return json An javascript object that contains `error` and `content` properties
 * @todo Better conditions support
 * @todo Suport for order statment
 */
	public function autocomplete()
	{
		$error = false;
		$content = '';
		$Model = null;
		
		$error = $this->BuroBurocrata->loadPostedModel($this, $Model);
		
		if($error === false)
		{
			$data = $this->buroData;
			
			// temporary conditions and order
			// todo: something more elaborated
			$conditions = $this->postConditions($data['autocomplete'], 'LIKE');
			$order = null;
			
			if(method_exists($Model, 'findBurocrataAutocomplete'))
				$content = $Model->findBurocrataAutocomplete($data);
			else
				$content = $Model->find('list', compact('conditions', 'order'));
		}
		
		$this->set('jsonVars', compact('error', 'content'));
	}

	
/**
 * 
 *
 * @access public
 * @return json An javascript object that contains `error` and `content` properties
 * @todo Better conditions support
 * @todo Suport for order statment
 */
	public function editable_list()
	{
		$id = $action = $Model = null;
		$error = $this->BuroBurocrata->loadPostedModel($this, $Model);
		
		if ($error === false)
		{
			if (isset($this->buroData['action']))
				$action = $this->buroData['action'];
			
			if (!empty($this->buroData['id']))
				$id = $this->buroData['id'];
			
			extract($this->BuroBurocrata->getViewData($this));
			$this->data = $data;
			
			$this->set(compact('data'));
		}
		
		$this->set(compact('error', 'action', 'saved', 'id'));
	}

/**
 * Creates a JSON with a preview text of a textile input.
 * 
 * @access public
 * @return json An javascript object that contains `error` and `content` properties
 */
	public function textile_preview()
	{
		$error = false;
		$content = '';
		if (!empty($this->data['text']))
		{
			App::import('Vendor', 'Textile');
			$Textile = new Textile();
			$content = $Textile->TextileThis($this->data['text']);
		}
		
		$this->set('jsonVars', compact('error', 'content'));
	}


/**
 * Attempts to delete an database entry
 *
 * @access public
 * @return json An javascript object that contains `error` and `content` properties
 * @todo Make
 */
	public function delete()
	{
	}


/**
 * Used on contentStream an on manyChildren inputs
 * 
 * @access public
 * @return json An javascript object whose properties depend on action requested
 */
	public function list_of_items()
	{
		$item_type = $id = $action = $Model = null;
		$error = $this->BuroBurocrata->loadPostedModel($this, $Model);
		
		if($error === false)
		{
			if (!empty($this->buroData['field']) && !empty($this->buroData['foreign_key']) && !$Model->Behaviors->attached('Ordered'))
				$Model->Behaviors->attach('JjUtils.Ordered', 
					array(
						'field' => $this->buroData['field'],
						'foreign_key' => $this->buroData['foreign_key']
					)
				);
			
			$debug = Configure::read()>0;
			$ordered = $Model->Behaviors->attached('Ordered');
			
			if (isset($this->buroData['action']))
				$action = $this->buroData['action'];
			
			if (isset($this->buroData['type']))
				$item_type = $this->buroData['type'];
			
			switch ($action)
			{
				case 'up':
					if ($ordered == false)
						$error = $debug?'BuroBurocrataController - Model does not act as ordered.':true;
					elseif (empty($this->buroData['id']))
						$error = $debug?'BuroBurocrataController - ID was not present on POST.':true;
					elseif ($Model->moveup($this->buroData['id']) == false)
						$error = $debug?'BuroBurocrataController - Model::moveup method returned false.':true;
					
					if (!$error)
						$id = $this->buroData['id'];
				break;
				
				case 'down':
					if ($ordered == false)
						$error = $debug?'BuroBurocrataController - Model does not act as ordered.':true;
					elseif (empty($this->buroData['id']))
						$error = $debug?'BuroBurocrataController - ID was not present on POST.':true;
					elseif ($Model->movedown($this->buroData['id']) == false)
						$error = $debug?'BuroBurocrataController - Model::movedown method returned false.':true;
					
					if (!$error)
						$id = $this->buroData['id'];
				break;
				
				case 'delete':
					if (empty($this->buroData['id']))
						$error = $debug?'BuroBurocrataController - ID was not present on POST.':true;
					elseif (method_exists($Model, 'buroDelete') && $Model->buroDelete($this->buroData['id']) == false)
						$error = $debug?'BuroBurocrataController - Model::buroDelete method returned false.':true;
					elseif ($Model->delete($this->buroData['id']) == false)
						$error = $debug?'BuroBurocrataController - Model::delete method returned false.':true;
					
					if (!$error)
						$id = $this->buroData['id'];
				break;
				
				case 'duplicate':
					if (empty($this->buroData['id']))
						$error = $debug?'BuroBurocrataController - ID was not present on POST.':true;
					
					if (!$error)
					{
						if (method_exists($Model, 'duplicate'))
						{
							if (!$Model->duplicate($$this->buroData['id']))
								$error = $debug?'BuroBurocrataController - Model::duplicate() failed.':true;
							else
								$id = $Model->id;
						}
						else
						{
							// Tries to duplicate (wont work if is necessary to duplicate children data)
							$data = $Model->find('first', array(
								'recursive' => -1,
								'conditions' => array(
									$Model->alias.'.'.$Model->primaryKey => $this->buroData['id']
								)
							));
							
							foreach (array('created', 'updated', 'modified', $Model->primaryKey) as $field)
								if (isset($data[$Model->alias][$field]))
									unset($data[$Model->alias][$field]);
							
							$Model->create();
							if (!$Model->save($data, false))
								$error = $debug?'BuroBurocrataController - Model did not save the duplicate data.':true;
							else
								$id = $Model->id;
						}
						
						if (!$error)
						{
							if ($ordered)
							{
								$this->set('order', $order+1);
								$saved = $id;
							}
							$this->set('old_id', $this->buroData['id']);
							$buroData = $this->BuroBurocrata->getViewData($this,$id);
							extract($buroData);
							$this->set(compact('data'));
						}
					}
				break;
				
				case 'edit':
					if (!empty($this->buroData['id']))
						$id = $this->buroData['id'];
					extract($this->BuroBurocrata->getViewData($this));
					$this->data = $data;
					$this->set(compact('data'));
				break;
				
				case 'afterEdit':
					if (!empty($this->buroData['id']))
						$id = $this->buroData['id'];
					extract($this->BuroBurocrata->getViewData($this));
					
					if (!$ordered)
					{
						list($model,$field) = pluginSplit($this->buroData['foreign_key']);
						
						$conditions = array($model.'.'.$field => $data[$model][$field]);
						$id_order = array_keys($Model->find('list', array('recursive' => -1, 'conditions' => $conditions)));
						$this->set(compact('id_order'));
					}
					
					$this->data = $data;
					$this->set(compact('data'));
				break;
			}
		
		}
		
		$this->set(compact('error', 'action', 'saved', 'id', 'item_type'));
	}


/**
 * 
 * 
 * @access public
 */
	public function unitary()
	{
		$id = $action = $Model = null;
		$error = $this->BuroBurocrata->loadPostedModel($this, $Model);
		
		if ($error === false)
		{
			if (isset($this->buroData['action']))
				$action = $this->buroData['action'];
			
			if (!empty($this->buroData['id']))
				$id = $this->buroData['id'];
			
			extract($this->BuroBurocrata->getViewData($this));
			$this->data = $data;
			
			$this->set(compact('data'));
		}
		
		$this->set(compact('error', 'action', 'saved', 'id'));
	}


/**
 * Simple function to pass foward the error message only if debug level > 0
 * 
 * @access protected
 * @param string $err_msg
 * @return string|true The error message or true depending on debug level
 */
	protected function _error($err_msg)
	{
		return Configure::read() > 0 ? $err_msg : true;
	}
}