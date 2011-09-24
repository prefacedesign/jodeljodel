<?php
	$object = compact('error', 'action', 'id');
	
	switch ($action)
	{
		case 'preview':
			$type = array('buro', 'view', 'belongsto');
			$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
		break;
		
		case 'new':
		case 'edit':
			if (!isset($data))
				$data = array();
			$type = array('buro', 'form', 'belongsto');
			$object['content'] = $this->Jodel->insertModule($model_class_name, $type, $data);
		break;
	}
	
	echo $this->Js->object($object);