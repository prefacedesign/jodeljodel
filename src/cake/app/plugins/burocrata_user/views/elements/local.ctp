<?php
	if(!isset($type)) $type = array(null);
	if(!is_array($type)) $type = array($type);
	
	switch($type[0])
	{
		case 'admin_form':
			echo $this->element('local_form');
		break;
		
		case 'burocrata':
			switch($type[1])
			{
				case 'form':
				case 'admin_form':
				case 'subform':
					echo $this->element('local_form');
				break;
				
				case 'view':
					echo $this->element('local_burocrata_view');
				break;
			}
		break;
		
		case 'admin_preview':
			switch($type[1])
			{
				case 'list_item':
				break;
				
				default:
				break;
			}
		break;
		
		case 'full_view':
		break;
		
		case 'preview':
			switch($type[1])
			{
				case 'event':
				break;
				
				default:
				break;
			}
		break;
	}