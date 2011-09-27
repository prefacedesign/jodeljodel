<?php
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