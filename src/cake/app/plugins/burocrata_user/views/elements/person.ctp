<?php
	if(!isset($type)) $type = array(null);
	if(!is_array($type)) $type = array($type);
	
	switch($type[0])
	{
		case 'admin_form':
			echo $this->element('user_form', array('plugin' => 'burocrata_user'));
		break;
		
		case 'buro':
			switch($type[1])
			{
				case 'form':
				case 'admin_form':
				case 'subform':
				case 'belongsto_form':
					echo $this->element('user_form', array('plugin' => 'burocrata_user'));
				break;
				
				case 'view':
				case 'admin_view':
				case 'preview':
				case 'belongsto_preview':
					echo $this->element('person_burocrata_view', array('plugin' => 'burocrata_user'));
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
