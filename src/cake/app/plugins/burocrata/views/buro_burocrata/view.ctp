<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

	
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