<?php
	$object = compact('error', 'action', 'id');
	
	switch ($action)
	{
		case 'duplicate':
			$type = array('buro', 'view', 'many_children');
			if (!isset($data)) 
				$data = array();
			
			$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
			
			if (isset($order))
				$object['order'] = $order-1;
			
			$object += compact('old_id');
		break;
	
		case 'edit':
			$type = array('buro', 'form', 'many_children');
			$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
		break;
	
		case 'save':
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