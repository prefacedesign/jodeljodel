<?php

	$object = compact('error', 'action', 'id');
	
	if ($action == 'edit')
	{
		App::import('Lib', 'ContentStream.CsConfigurator');
		$streams = CsConfigurator::getConfig('streams');
		$type = array('buro', 'content_stream', 'form');
		
		if (!isset($streams[$content_type]))
			trigger_error('ContentStream - Type `'.$content_type.'` not known.');
		else
			$object['content'] = $this->Jodel->insertModule($streams[$content_type]['model'], $type);
	}
	
	echo $this->Js->object($object);