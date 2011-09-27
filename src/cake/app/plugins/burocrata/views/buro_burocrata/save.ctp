<?php

	$object = compact('error', 'saved');
	$object['content'] = null;
	
	
	if(!$error)
	{
		if (!isset($data))
			$data = array();
		$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
	}
	
	echo $this->Js->object($object);