<?php
	
	$object['error'] = $error;
	$object['content'] = null;
	
	if(!$error)
	{
		$object['content'] = $this->Bl->div(
			array('id' => $div_id = uniqid('div')),
			array(), 
			$this->Jodel->insertModule($model_class_name, array('buro', 'view'), $data)
		);
	}
	
	echo $this->Js->object($object);