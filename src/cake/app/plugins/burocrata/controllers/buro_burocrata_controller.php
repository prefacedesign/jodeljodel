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
		$content = print_r($this->data, true);
		
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