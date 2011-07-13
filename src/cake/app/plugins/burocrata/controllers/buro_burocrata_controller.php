<?php

/**
 * Controller for burocrata plugin.
 *
 * PHP versions 5
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.views.helpers
 */
 
App::import('Lib', 'JjUtils.SecureParams');


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
 * @var string
 * @access public
 */
	public $components = array('Typographer.TypeLayoutSchemePicker', 'RequestHandler');


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
 * @access protected
 */
	protected $model_name = null;


/**
 * Plugin of the current model
 *
 * @var string
 * @access protected
 */
	protected $model_plugin = null;


/**
 * Current layout scheme
 *
 * @var string
 * @access protected
 */
	protected $layout_scheme = null;


/**
 * Holds some POSTed data
 *
 * @var array
 * @access protected
 */
	protected $buroData = array();


/**
 * beforeFilter callback
 * For while, it allows everyone to have access even if AuthComponent is set.
 * If is set $this->data['_b'], its data is passed to $this->buroData
 * If was POSTed a `baseID`, it repasses for the view.
 * And, finally, if is set a `layout_scheme`, it loads the Typographer helpers
 * 
 * @access public
 * @todo Better user filtering
 */
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('*');
		
		if(isset($this->data['_b']))
		{
			$this->buroData = $this->data['_b'];
			unset($this->data['_b']);
		}
		
		if(isset($this->buroData['baseID']))
			$this->set('baseID', $this->buroData['baseID']);
		
		if(isset($this->buroData['layout_scheme']))
		{
			$this->helpers = am($this->helpers,
				array(
					'Typographer.TypeDecorator' => array(
						'name' => 'decorator',
						'compact' => false,
						'receive_tools' => true
					),
					'Typographer.*TypeStyleFactory' => array(
						'name' => 'styleFactory', 
						'receive_automatic_classes' => true, 
						'receive_tools' => true,
						'generate_automatic_classes' => false
					),
					'Typographer.*TypeBricklayer' => array(
						'name' => 'Bl',
						'receive_tools' => true,
					),
					'Burocrata.*BuroBurocrata' => array(
						'name' => 'Buro'
					)
				)
			);
			$this->layout_scheme = $this->buroData['layout_scheme'];
			unset($this->buroData['layout_scheme']);
		}
	}


/**
 * beforeRender callback
 *
 * @access public
 */
	public function beforeRender()
	{
		if($this->layout_scheme)
			$this->TypeLayoutSchemePicker->pick($this->layout_scheme);
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
	public function save($type = '')
	{
		$saved = false;
		$Model = null;
		$error = $this->_load($Model);
		
		if (!empty($type))
			$type = array_reverse(explode('|',$type));
		else
			$type = array();
	
		
		if($error === false)
		{
			$methodName = 'saveBurocrata';   //Tries specific saves related to the type
			
			foreach($type as $k => $subType)
			{
				for ($i = count($type) - 1; $i >= $k; $i--)
					$methodName .= Inflector::camelize($type[$i]);
					
				if (method_exists($Model, $methodName))
					break;
				else
					$methodName = 'saveBurocrata';
			}
		
			if(method_exists($Model, $methodName))
				$saved = $Model->{$methodName}($this->data) !== false;
			else
				$saved = $Model->save($this->data) !== false;
			
			
			
			if($saved)
			{
				$saved = $Model->id;
				$this->data = array();
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
		$data = $this->_getViewData();
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
		
		$error = $this->_load($Model);
		
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
 * Return a list to fill the autocomplete field.
 *
 * @access public
 * @return json An javascript object that contains `error` and `content` properties
 * @todo Better conditions support
 * @todo Suport for order statment
 */
	public function new_editable_item()
	{
		$error = false;
		$content = '';
		$Model = null;
		
		$error = $this->_load($Model);
		
		if($error === false)
		{	
			$content = $Model->find('first', array('conditions' => array('id' => $this->buroData['id']), 'fields' => array('id', $Model->displayField)));
			$content = $content[$Model->alias];
			
		}
		
		$this->set('jsonVars', compact('error', 'content'));
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
		$id = $action = $Model = null;
		$error = $this->_load($Model);
		
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
							$buroData = $this->_getViewData($id);
							extract($buroData);
							$this->set(compact('data'));
						}
					}
				break;
				
				case 'edit':
					if (!empty($this->buroData['id']))
						$id = $this->buroData['id'];
					extract($this->_getViewData());
					$this->data = $data;
					$this->set(compact('data'));
				break;
				
				case 'afterEdit':
					if (!empty($this->buroData['id']))
						$id = $this->buroData['id'];
					extract($this->_getViewData());
					
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
		
		$this->set(compact('error', 'action', 'saved', 'id'));
	}


/**
 * Used to find data on database using burocratas conventions
 * based on passed id.
 * 
 * @access protected
 * @param $id mixed If empty will be used $this->buroData['id']
 * @return array An array with two index: `data` and `error`
 */
	protected function _getViewData($id = null)
	{
		$error = false;
		$data = array();
		$Model = null;
		
		if (empty($id) && !empty($this->buroData['id']))
			$id = $this->buroData['id'];
		
		if(($error = $this->_load($Model)) === false && !empty($id))
		{
			if (method_exists($Model, 'findBurocrata'))
				$data = $Model->findBurocrata($id);
			else
				$data = $Model->find('first', array(
					'recursive' => -1,
					'conditions' => array(
						$Model->alias.'.'.$Model->primaryKey => $id
					)
				));
		}
		return compact('error', 'data');
	}


/**
 * Loads the model especified in $this->data POST.
 *
 * @access protected
 * @param $var An variable to be filled with Model Object
 * @return mixed true when single model found and instance created, error returned if model not found.
 */
	protected function _load(&$var)
	{
		$debug = Configure::read()>0;
		$error = false;
		
		if(!isset($this->buroData['request']))
			$error = $debug?'BuroBurocrataController::_load - Request security field not defined':true;

		if($error === false)
		{
			// The counter-part of this code is in BuroBurocrataHelper::_security method
			@list($secure, $model_plugin, $model_alias) = SecureParams::unpack($this->buroData['request']);
			
			$hash = substr(Security::hash($this->here), -5);
			if($secure != $hash)
				$error = $debug?'BuroBurocrataController::_load - POST Destination check failed.':true;
		}

		if($error === false)
		{
			$model_class_name = $model_alias;
			if(!empty($model_plugin))
				$model_class_name = $model_plugin . '.' . $model_class_name;
			
			if(!$this->loadModel($model_class_name))
				$error = $debug?'BuroBurocrataController::_load - Couldn\'t load model.':true;
		}
		
		if($error === false)
		{
			$this->model_name = $model_alias;
			$this->model_plugin = $model_plugin;
			
			$this->set('model_name', $this->model_name);
			$this->set('model_plugin', $this->model_plugin);
			$this->set('model_class_name', $model_class_name);
			$this->set('fullModelName', $model_class_name);
			
			$var = $this->{$model_alias};
		}
		
		return $error;
	}
}