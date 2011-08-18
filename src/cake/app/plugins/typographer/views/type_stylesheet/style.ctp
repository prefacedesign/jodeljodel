<?php
	echo $this->element($element, array('plugin' => 'typographer'));	

	$typeDecorator->compact = true;
	foreach($used_automatic_classes as $type => $params) //produz todas as regras automáticas
	{
		$styleFactory->{$type . 'GenerateClasses'}($params);
	}
	Configure::write('debug', 0);