<?php
	
	switch ($type[0])
	{
		case 'buro':
			switch ($type[1])
			{
				case 'content_stream':
					echo $this->Jodel->insertModule('ContentStreamTest.CsFile', array($type[2]), $data);
				break;
			}
		break;
		
		case 'form':
			echo $this->Buro->sform(array(), array('model' => 'ContentStreamTest.CsFile'));
				echo $this->Buro->submit(array(), array(
					'label' => 'Salva',
					'cancel' => array(
						'label' => 'Cancelar'
					)
				));
			echo $this->Buro->eform();
		break;
		
		case 'view':
			echo 'file preview';
		break;
	}
	