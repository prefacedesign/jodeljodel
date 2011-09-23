<?php
switch ($type[0])
{
	case 'buro':
		App::import('Lib', 'ContentStream.CsConfigurator');
		$streams = CsConfigurator::getConfig('streams');
		
		// If is NOT a request for an empty form, get the type from $data
		if (!empty($data))
			$content_type = $data['CsItem']['type'];
		
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
			
			echo $this->Jodel->insertModule($streams[$content_type]['model'], array('buro', $type[1], 'content_stream'), $module_data);
			
			$this->data = $data_bkp;
		}
	break;
}