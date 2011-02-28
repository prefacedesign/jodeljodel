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
					'label' => __('Form - PapPaper.Journal - Select a Journal',true),
					'instructions' => __('Form - PapPaper.Journal - Instruction to belongsTo Journal',true),
					'options' => array(
						'model' => 'Paper.JourJournal',
						'type' => 'autocomplete',
						'allow' => array('create', 'modify', 'relate'),
						'new_item_text' => __('Form - PapPaper.Journal - Create a new Journal',true),
						'edit_item_text' => __('Form - PapPaper.Journal - Edit this Journal',true),
					)
				));
				
				
				/*
				echo $buro->input(array(),array(
					'type' => 'hasMany',
					'label' => __('Form - PapPaper.Author - Select multiples Authors',true),
					'instructions' => __('Form - PapPaper.Author - Instruction to list the Author',true),
					'options' => array(
						'model' => 'Author.AuthAuthor',
						'type' => 'list'
					)
				));
				*/
				
				
				echo $buro->input(array(), array(
					'type' => 'has_many',
					'fieldName' => 'AuthAuthor',
					'label' => __('Form - PapPaper.Author',true),
					'instructions' => __('Form - PapPaper.author - instructions',true),
					'options' => array('model' => 'AuthAuthor', 'type' => 'list', 'multiple' => true)
				));
				
				
				//echo $form->input('AuthAuthor');
				//echo $form->input('PapPaper.AuthAuthor', array('options' => $this->data['AuthAuthorList'], 'multiple'=>true));
				//debug($this->data);
				
				echo $buro->sinput(
					array(),
					array(
						'label' => __('Form - PapPaper new info superfield',true),
						'instructions' => __('Form - PapPaper new info superfield - instructions',true),
						'type' => 'super_field'
					)
				);
				
					
					echo $this->Buro->input(
						array(), 
						array(
							'fieldName' => 'date',
							'label' => __('Form - PapPaper.date',true),
							'instructions' => __('Form - PapPaper.date - instructions',true),
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
						'label' => __('Form - PapPaper.title',true),
						'instructions' => __('Form - PapPaper.title - instructions',true)
					));
					
					echo $buro->input(array(),array(
						'type' => 'textarea',
						'fieldName' => 'abstract',
						'label' => __('Form - PapPaper.abstract',true),
						'instructions' => __('Form - PapPaper.abstract - instructions',true)
					));
					
					
					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'Tag.tags',
						'label' => __('Form - PapPaper.tags',true),
						'instructions' => __('Form - PapPaper.tags - instructions',true)
					));
					
					/*
					echo $form->input('Tag.tags',array(
						'type' => 'text',
						'label' => __('Add Tags',true),
						'after' => __('Seperate each tag with a comma.  Eg: family, sports, icecream',true)
					));
					*/
					
					
				echo $buro->einput();

				
				echo $buro->sinput(
					array(),
					array(
						'label' => __('Form - PapPaper new reference superfield',true),
						'instructions' => __('Form - PapPaper new reference superfield - instructions',true),
						'type' => 'super_field'
					)
				);
				
					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'complete_reference',
						'label' => __('Form - PapPaper.complete_reference',true),
						'instructions' => __('Form - PapPaper.complete_reference - instructions',true)
					));
					
					
				
					
					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'link_to_it',
						'label' => __('Form - PapPaper.link_to_it',true),
						'instructions' => __('Form - PapPaper.link_to_it - instructions',true)
					));
					
					echo $buro->input(array(),array(
						'type' => 'upload',
						'fieldName' => 'file_id',
						'label' => __('Form - PapPaper.file_id',true),
						'instructions' => __('Form - PapPaper.file_id - instructions',true),
					));
				
				echo $buro->einput();
                
				
				echo $buro->submitBox(array(),array('publishControls' => false));
			echo $buro->eform();
		}
	break;
}

?>