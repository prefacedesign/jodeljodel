<?php

switch($type[0])
{
	case 'buro':
		switch($type[1])
		{
			case 'form':
				echo $this->element('picture_form', array('plugin' => 'burocrata_user'));
			break;
			
			case 'view':
				echo $this->Html->para('', $data['Picture']['title']);
				echo $this->Bl->img(array(), array('id' => $data['Picture']['file_upload_id'], 'version' => 'backstage_list'));
			break;
		}
	break;
}