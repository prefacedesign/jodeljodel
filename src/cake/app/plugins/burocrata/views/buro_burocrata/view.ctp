<?php
	
	$object['error'] = $error;
	$object['content'] = null;
	
	if(!$error)
	{
		$object['content'] = $this->Bl->div(array('id' => $div_id = uniqid('div')), array('escape' => false), 
			$this->element(Inflector::underscore($model_name),
				array(
					'plugin' => Inflector::underscore($model_plugin),
					'data' => $data,
					'type' => array('buro', 'view')
				)
			)
		);
	}
	
	echo $this->Js->object($object);