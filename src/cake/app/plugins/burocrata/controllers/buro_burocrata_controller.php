<?php

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
	public $view = 'Burocrata.Json';


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
 *
 * @access public
 */
	public function beforeFilter()
	{
		if(isset($this->data['_b']))
		{
			$this->buroData = $this->data['_b'];
			unset($this->data['_b']);
		}
		
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
	public function save()
	{
		$saved = false;
		$Model = null;
		$error = $this->_load($Model);
		
		if($error === false)
		{
			if(method_exists($Model, 'saveBurocrata'))
				$saved = $Model->saveBurocrata($this->data) !== false;
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
			$Model->recusrsive = -1;
			$this->data = $data = $Model->findById($this->buroData['id']);
		}
		
		$this->set(compact('error', 'data'));
	}


/**
 * Return a list to fill the autocomplete field.
 *
 * @access public
 * @return json An javascript object that contains `error` and `content` properties
 * @todo Better conditions suport
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
		
		if($error === false && empty($content))
			$content = array('-1' => __('Nothing found.', true));
		
		$this->set('jsonVars', compact('error', 'content'));
	}


/**
 * Attempts to delete an database entry
 *
 * @access public
 * @return json An javascript object that contains `error` and `content` properties
 */
	public function delete()
	{
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
			@list($model_plugin, $model_alias, $secure) = explode('|', $this->buroData['request']);
			unset($this->buroData['request']);
			
			$hash = Security::hash($this->here.$model_alias.$model_plugin);
			$uncip = Security::cipher(pack("H*" , $secure), $hash);
			if($uncip != $model_plugin.'.'.$model_alias)
				$error = __('Security hash didn\'t match.', true);
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
			
			$var = $this->{$model_alias};
		}
		
		return $error;
	}
}