<?php
	if(!isset($type)) $type = array(null);
	if(!is_array($type)) $type = array($type);
	
	switch($type[0])
	{
		case 'admin_form':
			echo $this->element('user_form', array('plugin' => 'burocrata_user'));
		break;
		
		case 'burocrata':
			switch($type[1])
			{
				case 'form':
				case 'admin_form':
				case 'subform':
					echo $this->element('user_form', array('plugin' => 'burocrata_user'));
				break;
				
				case 'view':
					echo $this->element('user_burocrata_view', array('plugin' => 'burocrata_user'));
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
