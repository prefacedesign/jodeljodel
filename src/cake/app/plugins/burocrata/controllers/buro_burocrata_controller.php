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
		
		if(!isset($this->data['modelAlias']) || !isset($this->data['modelPlugin']) || !isset($this->data['hash']))
			$error = 'Model and security fields not defineds';
		
		if(!$error)
		{
			$hash = Security::hash($this->here.$this->data['modelAlias'].$this->data['modelPlugin'],'sha1',true);
			if($hash != $this->data['hash'])
				$error = 'Security hash didn\'t match.';
		}
		
		if(!$error)
		{
			$model_name = $this->data['modelAlias'];
			if(!empty($this->data['modelPlugin']))
				$model_name = $this->data['modelPlugin'] . '.' . $model_name;
			
			if(!$this->loadModel($model_name))
				$error = 'Couldn\'t load model';
		}
		
		if(!$error)
		{
			$Model =& $this->{$this->data['modelAlias']}; 
			if(method_exists($Model, 'saveBurocrata'))
				$saved = $Model->saveBurocrata($this->data) !== false;
			else
				$saved = $Model->save($this->data) !== false;
		}
		
		$this->set('jsonVars', compact(
			'saved', 'content', 'error'
		));
	}
	
	
	function view()
	{
	}
	
	
	function delete()
	{
	}
}