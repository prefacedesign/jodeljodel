<?php

switch ($type[0])
{
	case 'buro':
		switch ($type[1])
		{
			case 'form':
				echo $this->Buro->sform(array(), array('model' => 'PieText.PieText'));
					
					echo $this->Buro->input(
						array(), 
						array(
							'fieldName' => 'text',
							'type' => 'textile',
							'options' => array(
								'enabled_buttons' => array('bold', 'italic', 'link'),
								'allow_preview' => false
							)
						)
					);
					
					echo $this->Buro->submit(array(), array('cancel' => true));
					
				echo $this->Buro->eform();
			break;
			
			case 'view':
				echo $data['PieText']['processed_text'];
			break;
		}
	break;
}