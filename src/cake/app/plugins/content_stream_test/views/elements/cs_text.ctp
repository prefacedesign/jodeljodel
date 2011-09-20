<?php
	
	switch ($type[0])
	{
		case 'buro':
			switch ($type[1])
			{
				case 'content_stream':
					echo $this->Jodel->insertModule('ContentStreamTest.CsText', array($type[2]), $data);
				break;
			}
		break;
		
		case 'form':
			echo $this->Buro->sform(array(), array('model' => 'ContentStreamTest.CsText'));
				echo $this->Buro->input(array(), array(
					'label' => 'Some text',
					'fieldName' => 'text',
					'type' => 'textarea'
				));
				echo $this->Buro->submit(array(), array(
					'label' => 'Salva',
					'cancel' => array(
						'label' => 'Cancelar'
					)
				));
			echo $this->Buro->eform();
			echo $this->Bl->floatBreak();
		break;
		
		case 'view':
			echo $this->Bl->paraDry(explode("\n", $data['CsText']['text']));
		break;
	}
	