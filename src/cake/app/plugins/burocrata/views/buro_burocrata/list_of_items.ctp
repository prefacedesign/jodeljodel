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
	
	if (!isset($data)) 
		$data = array();
	
	switch ($action)
	{
		case 'duplicate':
			$type = array('buro', 'view', 'many_children');
			
			$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
			
			if (isset($order))
				$object['order'] = $order-1;
			
			$object += compact('old_id');
		break;
	
		case 'edit':
		case 'save':
			$type = array('buro', 'form', 'many_children');
			$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
			
			if (isset($saved))
				$object += compact('saved');
		break;
	
	
		case 'afterEdit':
			$type = array('buro', 'view', 'many_children');
			$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
			
			if (isset($data[$model_name]['__title']))
				$object['title'] = $data[$model_name]['__title'];
			
			if (isset($id_order))
				$object['id_order'] = $id_order;
		break;
	}
	
	echo $this->Js->object($object);