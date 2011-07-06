<?php
	switch($type[0])
	{
		case 'buro':
			switch($type[1])
			{
				case 'many_children':
					switch($type[2])
					{
						case 'view': echo $this->Jodel->insertModule('BurocrataUser.Something', array('view'), $data); break;
						case 'form': echo $this->Jodel->insertModule('BurocrataUser.Something', array('form'), $data); break;
					}
				break;
				
				case 'view':
					echo $this->Jodel->insertModule('BurocrataUser.Something', array('view'), $data);
				break;
				
				case 'form':
					echo $this->Jodel->insertModule('BurocrataUser.something', array('form'), $data);
				break;
			}
		break;
		
		case 'view':
			echo $this->Html->tag('strong', $data['Something']['id']);
			echo $this->Html->para('', $data['Something']['some_text']);
			echo $this->Html->para('', 'Última alteração: '. date('d/m/Y H:i:s', strtotime($data['Something']['modified'])) . ' ('.$this->Time->timeAgoInWords($data['Something']['modified']).')');
		break;
		
		case 'form':
			echo $this->Buro->sform(array(), array('model' => 'BurocrataUser.Something'));
				
				echo $this->Buro->input(
					array('value' => $baseID, 'name' => $this->Buro->internalParam('baseID')),
					array('type' => 'hidden')
				);
				
				echo $this->Buro->input(
					array(),
					array('fieldName' => 'id', 'type' => 'hidden')
				);
				
				echo $this->Buro->input(
					array(),
					array('fieldName' => 'some_text', 'type' => 'textarea')
				);
				
				echo $this->Buro->submit(
					array(),
					array('label' => 'Salva','cancel' => array('label' => 'Cancelar'))
				);
			echo $this->Buro->eform();
			echo $this->Bl->floatBreak();
		break;
	}