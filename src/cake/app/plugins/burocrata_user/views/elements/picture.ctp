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
					}
				break;
			}
		break;
		
		case 'view':
			echo $this->Html->para('', $data['Picture']['title']);
		break;
	}