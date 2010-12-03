<?php
	
	$object['error'] = $error;
	$object['content'] = null;
	
	if(!$error)
	{
		
		$object['content'] = $this->element(Inflector::underscore($model_name),
			array(
				'plugin' => Inflector::underscore($model_plugin),
				'data' => $data,
				'type' => array('burocrata', 'view')
			)
		);
	}
	
	echo $this->Js->object($object);