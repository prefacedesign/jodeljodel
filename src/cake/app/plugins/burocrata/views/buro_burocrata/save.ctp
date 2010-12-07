<?php

	$object = compact('error', 'saved');
	$object['content'] = null;
	
	if(!$error)
	{
		$object['content'] = $this->element(Inflector::underscore($model_name),
			array(
				'plugin' => Inflector::underscore($model_plugin),
				'type' => array('burocrata', 'form')
			)
		);
	}
	
	echo $this->Js->object($object);