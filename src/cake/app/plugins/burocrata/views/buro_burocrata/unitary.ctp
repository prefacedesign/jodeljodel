<?php
	$object = compact('error', 'action', 'id');
	
	if ($action == 'preview')
		$object['content'] = $this->Jodel->insertModule($model_class_name, array('buro', 'belongsto_preview'), $data);
	
	if ($action == 'edit')
		$object['content'] = $this->Jodel->insertModule($model_class_name, array('buro', 'belongsto_form'), $data);
	
	echo $this->Js->object($object);