<?php
switch ($type[0])
{
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
					'type' => 'belongsTo',
					'label' => __('Form - NewsNew.Author - Select a Author',true),
					'instructions' => __('Form - NewsNew.Author - Instruction to belongsTo Author',true),
					'options' => array(
						'model' => 'Author.AuthAuthor',
						'type' => 'autocomplete',
						'allow' => array('create', 'modify', 'relate'),
						'new_item_text' => __('Form - NewsNew.Author - Create a new Author',true),
						'edit_item_text' => __('Form - NewsNew.Author - Edit this Author',true),
					)
				));

				
				echo $buro->sinput(
					array(),
					array(
						'label' => __('Form - NewsNew new info superfield',true),
						'instructions' => __('Form - NewsNew new info superfield - instructions',true),
						'type' => 'super_field'
					)
				);
				
					
					echo $this->Buro->input(
						array(), 
						array(
							'fieldName' => 'date',
							'label' => __('Form - NewsNew.date',true),
							'instructions' => __('Form - NewsNew.date - instructions',true),
							'type' => 'datetime',
							'options' => array(
								'dateFormat' => 'DMY',
								'timeFormat' => null,
								'separator' => ''
							)
						)
					);
				
					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'title',
						'label' => __('Form - NewsNew.title',true),
						'instructions' => __('Form - NewsNew.title - instructions',true)
					));
					
					echo $buro->input(array(),array(
						'type' => 'textarea',
						'fieldName' => 'abstract',
						'label' => __('Form - NewsNew.abstract',true),
						'instructions' => __('Form - NewsNew.date - abstract',true)
					));
					
					echo $buro->input(array(),array(
						'type' => 'textarea',
						'fieldName' => 'content',
						'label' => __('Form - NewsNew.content',true),
						'instructions' => __('Form - NewsNew.content - instructions',true)
					));
				
				echo $buro->einput();
                
				
				echo $buro->submitBox(array(),array('publishControls' => false));
			echo $buro->eform();
		}
	break;
}

?>