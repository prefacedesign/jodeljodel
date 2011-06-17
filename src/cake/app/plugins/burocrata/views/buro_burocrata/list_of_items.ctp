<?php
	$object = compact('error', 'action', 'id');
	
	if ($action == 'duplicate')
	{
		$object += compact('old_id');
	}
	
	if (in_array($action, array('duplicate', 'edit')))
	{
		$type = array('buro', 'many_children', 'view');
		if (!isset($data)) $data = array();
		$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
		$object['order'] = $order-1;
	}
	
	echo $this->Js->object($object);