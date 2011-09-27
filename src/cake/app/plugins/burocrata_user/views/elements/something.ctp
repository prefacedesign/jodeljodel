<?php

switch($type[0])
{
	case 'buro':
		switch($type[1])
		{
			case 'view':
				echo $this->Html->para('', $data['Something']['some_text']);
				echo $this->Html->para('', 'Última alteração: '. date('d/m/Y H:i:s', strtotime($data['Something']['modified'])));
			break;
			
			case 'form':
				echo $this->Buro->sform(array(), array('model' => 'BurocrataUser.Something'));
					
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
	break;
}