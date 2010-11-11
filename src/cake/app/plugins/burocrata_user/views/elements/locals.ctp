<?php
	if(!isset($type)) $type = array(null);
	
	switch($type[0])
	{
		case 'admin_form':
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