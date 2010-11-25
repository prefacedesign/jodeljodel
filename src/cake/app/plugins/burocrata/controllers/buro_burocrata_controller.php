<?php

class BuroBurocrataController extends BurocrataAppController
{
	var $name = 'BuroBurocrata';
	var $uses = array();
	var $view = 'Burocrata.Json';
	
	function save()
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
		}
		
		$this->set('jsonVars', compact(
			'saved', 'content', 'error'
		));
	}
	
	
	function autocomplete()
	{
		$error = false;
		$content = '';
		$Model = null;
		
		$error = $this->_load($Model);
		
		if(!$error)
		{
			$data = $this->data;
			unset($data['request']);
			
			$conditions = $this->postConditions($data, 'LIKE');
			
			if(method_exists($Model, 'findBurocrataAutocomplete'))
				$content = $Model->findBurocrataAutocomplete($conditions);
			else
				$content = $Model->find('list', compact('conditions', 'order'));
		}
		
		if(!$error && empty($content))
			$content = array('-1' => __('Nothing found.', true));
		
		$this->set('jsonVars', compact('error', 'content'));
	}
	
	
	function view()
	{
		
	}
	
	
	function delete()
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
			$error = 'Request security field not defined';
		
		if(!$error)
		{
			// The counter-part of this code is in BuroBurocrataHelper::_security method
			@list($model_plugin, $model_alias, $secure) = explode('|', $this->data['request']);
			$hash = Security::hash($this->here.$model_alias.$model_plugin);
			$uncip = Security::cipher(pack("H*" , $secure), $hash);
			if($uncip != $model_plugin.'.'.$model_alias)
				$error = 'Security hash didn\'t match.';
		}
		
		if(!$error)
		{
			$model_class_name = $model_alias;
			if(!empty($model_plugin))
				$model_class_name = $model_plugin . '.' . $model_class_name;
			
			if(!$this->loadModel($model_class_name))
				$error = 'Couldn\'t load model';
		}
		
		if(!$error)
			$var = $this->{$model_alias};
		
		return $error;
	}
}