<?php
	$object = compact('error', 'action', 'id');
	
	switch ($action)
	{
		case 'preview':
			$object['content'] = $this->Jodel->insertModule($model_class_name, array('buro', 'preview'), $data);
		break;
		
		case 'new':
		case 'edit':
			if (!isset($data))
				$data = array();
			$object['content'] = $this->Jodel->insertModule($model_class_name, array('buro', 'form'), $data);
		break;
	}
	
	echo $this->Js->object($object);