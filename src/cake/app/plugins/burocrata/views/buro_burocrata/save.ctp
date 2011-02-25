<?php

	$object = compact('error', 'saved');
	$object['content'] = null;
	
	if(!$error)
	{
		$class_name = $model_name;
		if(!empty($model_plugin))
			$class_name = $model_plugin . '.' . $class_name;
		
		//debug($class_name);
		$object['content'] = $this->Buro->insertForm($class_name);
		//debug($object);
	}
	
	echo $this->Js->object($object);