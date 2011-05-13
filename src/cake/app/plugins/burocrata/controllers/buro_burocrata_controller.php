<?php

App::import('Lib', 'JjUtils.SecureParams');

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
			$methodName = 'saveBurocrata';   //Trys specific saves related to the type
			
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
		$error = false;
		$data = array();
		$Model = null;
		
		$error = $this->_load($Model);
				
		if($error === false)
		{
			$this->data = $data = $Model->find('first', array(
				'recursive' => -1,
				'conditions' => array(
					$Model->alias.'.'.$Model->primaryKey => $this->buroData['id']
				)
			));
		}
	
		$this->set(compact('error', 'data'));
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
 * @return json An javascript object that contains only `error` properties
 */
	public function list_of_items($action = null)
	{
		$Model = null;
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
			
			$ordered = $Model->Behaviors->attached('Ordered');
			
			switch ($action)
			{
				case 'up':
					$error = $ordered == false || 
							 empty($this->buroData['id']) || 
							 $Model->moveup($this->buroData['id']) == false;
				break;
				
				case 'down':
					$error = $ordered == false || 
							 empty($this->buroData['id']) || 
							 $Model->movedown($this->buroData['id']) == false;
				break;
				
				case 'delete':
					$error = empty($this->buroData['id']) || 
							 $Model->delete($this->buroData['id']) == false;
				break;
				
				case 'duplicate':
					$error = empty($this->buroData['id']);
					if (!$error)
					{
						$data = $Model->find('first', array(
							'recursive' => -1,
							'conditions' => array(
								$Model->alias.'.'.$Model->primaryKey => $this->buroData['id']
							)
						));
						if ($ordered)
						{
							$order = $data[$Model->alias][$this->buroData['field']];
							unset($data[$Model->alias][$this->buroData['field']]);
						}
						
						foreach (array('created', 'updated', 'modified', $Model->foreign_key) as $field)
							if (isset($data[$Model->alias][$field]))
								unset($data[$Model->alias][$field]);
						
						$Model->create();
						$error = !$Model->save($data, false);
						if (!$error && $ordered)
							$Model->moveto($order+1);
					}
				break;
				
				case 'edit':
					$this->edit();
				break;
			}
		
		}
	
		$this->set('jsonVars', compact('error'));
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
		$error = false;
		
		if(!isset($this->buroData['request']))
			$error = __('Request security field not defined', true);

		if($error === false)
		{
			// The counter-part of this code is in BuroBurocrataHelper::_security method
			@list($secure, $model_plugin, $model_alias) = SecureParams::unpack($this->buroData['request']);
			unset($this->buroData['request']);
			
			$hash = substr(Security::hash($this->here), -5);
			if($secure != $hash)
				$error = __('POST Destination check failed.', true);
		}

		if($error === false)
		{
			$model_class_name = $model_alias;
			if(!empty($model_plugin))
				$model_class_name = $model_plugin . '.' . $model_class_name;
			
			if(!$this->loadModel($model_class_name))
				$error = __('Couldn\'t load model', true);
		}
		
		if($error === false)
		{
			$this->model_name = $model_alias;
			$this->model_plugin = $model_plugin;
			
			$this->set('model_name', $this->model_name);
			$this->set('model_plugin', $this->model_plugin);
			$this->set('fullModelName', $model_class_name);
			
			$var = $this->{$model_alias};
		}
		
		return $error;
	}
}