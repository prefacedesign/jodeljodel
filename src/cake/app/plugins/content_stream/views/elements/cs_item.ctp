<?php

	App::import('Lib', 'ContentStream.CsConfigurator');
	$streams = CsConfigurator::getConfig('streams');

	if (!isset($content_type))
		$content_type = null;
	
	// If is NOT a request for an empty form, tries to get the type from $data
	if (!empty($data))
	{
		$content_type = $data['CsItem']['type'];
	}
	
	// If $content_type stills empty here, tries to get directly from database, based on POST
	if (empty($content_type) && !empty($this->data['CsItem']['id']))
	{
		$CsItem = ClassRegistry::init($model_class_name);
		$CsItem->id = $this->data['CsItem']['id'];
		$content_type = $CsItem->field('type');
	}
	
	if (!isset($streams[$content_type]))
	{
		trigger_error('ContentStream - Type `'.$content_type.'` not known.');
	}
	else
	{
		$module_data = array();
		if (!empty($data))
			$module_data = $data['CsItem'];
		
		$data_bkp = $this->data;
		$this->data = $module_data;
		
		// Some hardcoded logic... ugly, but effective!
		if ($type[0] == 'buro')
			$type[2] = 'content_stream';
		elseif ($type[1] != 'cork')
			$type[] = 'content_stream';
		
		echo $this->Jodel->insertModule($streams[$content_type]['model'], $type, $module_data);
		
		$this->data = $data_bkp;
	}