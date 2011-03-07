<?php

//@todo Make something more interesting for datetime formatting. Maybe a helper.



switch ($type[0])
{
	case 'preview':
		echo $this->Bl->h4Dry(_formatInterval(strtotime($data['EveEvent']['begins']), strtotime($data['EveEvent']['ends'])));
		
		echo $this->Bl->h4Dry($this->Bl->anchor(array(), array('url' => $data['EveEvent']['link']),	$data['EveEvent']['name']));
		
		echo $this->Bl->para(array(),array(),array($data['EveEvent']['abstract']));
	break;
	
	case 'buro':
		if ($type[1] == 'form')
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
					'type' => 'text',
					'fieldName' => 'EveEvent.name',
					'label' => __('Form - EveEvent.name',true),
					'instructions' => __('Form - EveEvent.name - instructions',true)
				));
				
				echo $buro->input(array(),array(
					'type' => 'textarea',
					'fieldName' => 'abstract',
					'label' => __('Form - EveEvent.abstract',true),
					'instructions' => __('Form - EveEvent.abstract - instructions',true)
				));
					
				echo $buro->input(array(),array(
					'type' => 'text',
					'fieldName' => 'EveEvent.link',
					'label' => __('Form - EveEvent.link',true),
					'instructions' => __('Form - EveEvent.link - instructions',true)
				));
			
				echo $this->Buro->input(
					array(), 
					array(
						'fieldName' => 'begins',
						'label' => __('Form - EveEvent.begins',true),
						'instructions' => __('Form - EveEvent.begins - instructions',true),
						'type' => 'datetime',
						'options' => array(
							'dateFormat' => 'DMY',
							'timeFormat' => null,
							'separator' => ''
						)
					)
				);
				
				echo $this->Buro->input(
					array(), 
					array(
						'fieldName' => 'ends',
						'label' => __('Form - EveEvent.ends',true),
						'instructions' => __('Form - EveEvent.ends - instructions',true),
						'type' => 'datetime',
						'options' => array(
							'dateFormat' => 'DMY',
							'timeFormat' => null,
							'separator' => ''
						)
					)
				);
					
				echo $buro->submitBox(array(),array('publishControls' => false));
			echo $buro->eform();
		}
	break;
	
}

?>