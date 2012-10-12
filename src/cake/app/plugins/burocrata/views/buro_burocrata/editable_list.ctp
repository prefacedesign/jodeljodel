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

	$object = compact('error', 'action', 'id');
	
	switch ($action)
	{
		case 'preview':
			$type = array('buro', 'preview', 'editable_list');
			$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
		break;

		case 'add':
			$type = array('buro', 'view', 'editable_list');
			$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
		break;
		
		case 'new':
		case 'edit':
			if (!isset($data))
				$data = array();
			$type = array('buro', 'form', 'editable_list');
			$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
		break;
	}
	
	echo $this->Js->object($object);