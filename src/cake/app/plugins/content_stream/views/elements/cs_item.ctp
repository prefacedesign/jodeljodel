<?php
switch ($type[0])
{
	case 'buro':
		switch ($type[1])
		{
			case 'many_children':
				App::import('Lib', 'ContentStream.CsConfigurator');
				$streams = CsConfigurator::getConfig('streams');
				
				if (!isset($streams[$item_type]))
					trigger_error('ContentStream - Type `'.$item_type.'` not known.');
				else
					echo $this->Jodel->insertModule($streams[$item_type]['model'], array('buro', 'content_stream', $type[2]));
			break;
		}
	break;
}