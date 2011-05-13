<?php
	switch($type[0])
	{
		case 'buro':
			switch($type[1])
			{
				case 'many_children':
					switch($type[2])
					{
						case 'view': echo $this->Jodel->insertModule('BurocrataUser.Picture', array('view'), $data); break;
						case 'form': echo $this->Jodel->insertModule('BurocrataUser.Picture', array('form'), $data); break;
					}
				break;
				
				case 'form':
					echo $this->Jodel->insertModule('BurocrataUser.Picture', array('form'), $data);
				break;
			}
		break;
		
		case 'view':
			echo $this->Html->para('', $data['Picture']['title']);
			echo $this->Bl->img(array(), array('id' => $data['Picture']['file_upload_id'], 'version' => 'backstage_list'));
		break;
		
		case 'form':
			echo $this->element('picture_form', array('plugin' => 'burocrata_user'));
		break;
	}