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
 * Attempts to save the data POSTed 
 * The JSON object returned has 3 attributes:
 * - `error` - is false when everyting went ok, or an frindly string describing the error
 * - `saved` - is false when couldn't saved the data, or the ID of the new entry on database
 * - `content` - i realy don't know, yet, why this is here, but will be used for something
 * 
 * @access public
 * @return json An javascript object that contains `error`, `content` and `saved` properties
 */
	public function save()
	{
		$saved = false;
		$error = false;
		$content = '';
		$Model = null;
		
		$error = $this->_load($Model);
		
		if(!$error)
		{
			if(method_exists($Model, 'saveBurocrata'))
				$saved = $Model->saveBurocrata($this->data) !== false;
			else
				$saved = $Model->save($this->data) !== false;
			
			if($saved)
				$saved = $Model->id;
		}
		
		$this->set('jsonVars', compact(
			'saved', 'content', 'error'
		));
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
		
		if(!$error)
		{
			$data = $this->data;
			unset($data['request']);
			
			// temporary conditions and order
			// todo: something more elaborated
			$conditions = $this->postConditions($data, 'LIKE');
			$order = null;
			
			if(method_exists($Model, 'findBurocrataAutocomplete'))
				$content = $Model->findBurocrataAutocomplete($data);
			else
				$content = $Model->find('list', compact('conditions', 'order'));
		}
		
		if(!$error && empty($content))
			$content = array('-1' => __('Nothing found.', true));
		
		$this->set('jsonVars', compact('error', 'content'));
	}


/**
 * Return a JSON object containing an already rendered and populated element
 *
 * @access public
 * @return json An javascript object that contains `error` and `content` properties
 */
	public function view()
	{
		
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
		
		if(!isset($this->data['request']))
			$error = __('Request security field not defined', true);
		
		if(!$error)
		{
			// The counter-part of this code is in BuroBurocrataHelper::_security method
			@list($model_plugin, $model_alias, $secure) = explode('|', $this->data['request']);
			unset($this->data['request']);
			
			$hash = Security::hash($this->here.$model_alias.$model_plugin);
			$uncip = Security::cipher(pack("H*" , $secure), $hash);
			if($uncip != $model_plugin.'.'.$model_alias)
				$error = __('Security hash didn\'t match.', true);
		}
		
		if(!$error)
		{
			$model_class_name = $model_alias;
			if(!empty($model_plugin))
				$model_class_name = $model_plugin . '.' . $model_class_name;
			
			if(!$this->loadModel($model_class_name))
				$error = __('Couldn\'t load model', true);
		}
		
		if(!$error)
			$var = $this->{$model_alias};
		
		return $error;
	}
}