<?php
	
	switch($type[0])
	{
		case 'cork':
			if (!isset($type[1]))
			{
				echo $this->Bl->paraDry(explode("\n", $this->Text->autoLink($data['TextTextCork']['text'])));
			}
		break;
		case 'buro':
			if (isset($type[1]) && $type[1] == 'form' && isset($type[2]) && $type[2] == 'cork')
			{
				echo $buro->sform(array(), array(
					'model' => $fullModelName,
					'callbacks' => array(
						'onReject' => array('js' => '$("content").scrollTo(); showPopup("error");', 'contentUpdate' => 'replace'),
						'onSave' => array('js' => '$("content").scrollTo(); showPopup("notice");'),
					)
				));
				
					echo $buro->input(array(),array(
						'type' => 'hidden',
						'fieldName' => 'id'
					));
					
					echo $buro->input(array(),array(
						'type' => 'textarea',
						'fieldName' => 'text',
						'label' => __('Cork Form - TextTextCork.text',true),
						'instructions' => __('Cork Form - TextTextCork.text - instructions',true)
					));				
					//@todo Customize submitBox.
					echo $buro->submitBox(array('label' => 'Salvar'));
				echo $buro->eform();
			}
		break;
	}
?>
