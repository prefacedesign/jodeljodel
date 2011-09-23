<?php

switch ($type[0])
{
	case 'buro':
		switch ($type[1])
		{
			case 'form':
				echo $this->Buro->sform(array(), array('model' => 'BurocrataUser.CsText'));
					echo $this->Buro->input(array(), array(
						'fieldName' => 'id',
						'type' => 'hidden'
					));
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
	break;
}
