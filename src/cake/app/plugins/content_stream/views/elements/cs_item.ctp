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


	App::import('Lib', 'ContentStream.CsConfigurator');
	$streams = CsConfigurator::getConfig('streams');

	if (!isset($content_type))
		$content_type = null;
	
	// If is NOT a request for an empty form, tries to get the type from $data
	if (!empty($data))
	{
		$content_type = $data['CsItem']['type'];
	}
	
	if (empty($content_type) && isset($this->data['CsItem']['type']))
	{
		$content_type = $this->data['CsItem']['type'];	
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
		
		echo $this->Bl->div(
			array('class' => $content_type), null,
			$this->Jodel->insertModule($streams[$content_type]['model'], $type, $module_data)
		);
		
		$this->data = $data_bkp;
	}
