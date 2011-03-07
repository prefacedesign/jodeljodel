<?php
	
	switch($type[0])
	{
		case 'cork':
			if (!isset($type[1]))
			{
				if (isset($data['CorkCorktile']['options']['textile']) && $data['CorkCorktile']['options']['textile'])
				{
					echo $this->Bl->textileDry($data['TextTextCork']['text']);
				}
				else
				{
					if (isset($data['CorkCorktile']['options']['convertLinks']) && $data['CorkCorktile']['options']['convertLinks'])
						echo $this->Bl->paraDry(explode("\n", $this->Text->autoLink($data['TextTextCork']['text'])));
					else
						echo $this->Bl->paraDry(explode("\n", $data['TextTextCork']['text']));
				}
			}
		break;
		case 'buro':
			if (isset($type[1]) && $type[1] == 'form' && isset($type[2]) && $type[2] == 'cork')
			{
				echo $buro->sform(array(), array(
					'model' => $fullModelName,
					'type' => array('cork'),
					'callbacks' => array(
						'onReject' => array('js' => '$("content").scrollTo(); showPopup("error");', 'contentUpdate' => 'replace'),
						'onSave' => array('js' => '$("content").scrollTo(); showPopup("notice");'),
					)
				));
				
					echo $buro->input(array(),array(
						'type' => 'hidden',
						'fieldName' => 'id'
					));
					
					if (isset($this->data['CorkCorktile']['options']['textile']) && $this->data['CorkCorktile']['options']['textile'])
					{
						echo $buro->input(array(),array(
							'type' => 'textile',
							'fieldName' => 'text',
							'label' => __('Cork Form - TextTextCork.text',true),
							'instructions' => __('Cork Form - TextTextCork.text - instructions',true)
						));
					}
					else
					{
						echo $buro->input(array(),array(
							'type' => 'textarea',
							'fieldName' => 'text',
							'label' => __('Cork Form - TextTextCork.text',true),
							'instructions' => __('Cork Form - TextTextCork.text - instructions',true)
						));
					}
					
					//@todo Customize submitBox.
					echo $buro->submitBox(array(), array('publishControls' => false));
				echo $buro->eform();
			}
		break;
	}
?>
