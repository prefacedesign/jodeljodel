<?php
	$object = compact('error', 'action', 'id');
	
	if ($action == 'duplicate')
	{
		$object += compact('old_id');
		$type = array('buro', 'many_children', 'view');
		if (!isset($data)) $data = array();
		$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
		$object['order'] = $order-1;
	}
	
	if ($action == 'edit')
	{
		$type = array('buro', 'many_children', 'form');
		$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
	}
	
	if ($action == 'afterEdit')
	{
		$type = array('buro', 'many_children', 'view');
		$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
	}
	
	echo $this->Js->object($object);