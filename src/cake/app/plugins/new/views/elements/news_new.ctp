<?php
switch ($type[0])
{
	case 'preview':
		echo $this->Bl->span(array('class' => 'texto_pequeno'), array(),br_strftime('%d de %B', strtotime($data['NewsNew']['date'])));

		echo $this->Bl->h4(array(),array(),$this->Bl->anchor(
				array(),
				array(
					'url' => array(
						'plugin' => 'new',
						'controller' => 'news_new',
						'action' => 'view',
						$data['NewsNew']['id']
					)
				),
				$data['NewsNew']['title']
			)
		);


		echo $this->Bl->para(array(),array(),array($data['NewsNew']['abstract']));
	break;

	case 'full':
		echo $this->Bl->h2(array(),array(),$data['NewsNew']['title']);
		echo $this->Bl->span(array('class' => 'texto_pequeno'), array(),
			br_strftime('%d de %B de %Y', strtotime($data['NewsNew']['date']))
			. ', por ' .$data['AuthAuthor']['name']);

		echo $this->Bl->brDry();
		echo $this->Bl->brDry();

		echo $this->Bl->textileDry($data['NewsNew']['content']);


	break;

	case 'linha_link':
		echo $this->Bl->span(array('class' => array('texto_pequeno', 'caixinha', 'larg_4i')), array(),
				br_strftime('%d/%m', strtotime($data['NewsNew']['date'])) );


		echo $this->Bl->span(array('class' => array('caixinha_2', 'larg_3M_-3i_-1m')),
				array('escape' => true),
				$this->Bl->anchor(
				array(),
				array(
					'url' => array(
						'plugin' => 'new',
						'controller' => 'news_new',
						'action' => 'view',
						$data['NewsNew']['id']
					)
				),
				$data['NewsNew']['title']
			)
		);


		echo $this->Bl->floatBreak();
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
						'instructions' => __('Form - NewsNew.abstract - instructions',true)
					));
					
					echo $buro->input(array(),array(
						'type' => 'textile',
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