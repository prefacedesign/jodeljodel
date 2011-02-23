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


				echo $buro->sinput(
					array(),
					array(
						'label' => __('Form - PersPerson name superfield',true),
						'instructions' => __('Form - PersPerson name superfield - instructions',true),
						'type' => 'super_field'
					)
				);
					echo $buro->input(array(),array(
						'type' => 'hidden',
						'fieldName' => 'AuthAuthor.id'
					));
					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'AuthAuthor.surname',
						'label' => __('Form - PersPerson.surname',true),
						'instructions' => __('Form - PersPerson.surname - instructions',true)
					));

					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'AuthAuthor.name',
						'label' => __('Form - PersPerson.name',true),
						'instructions' => __('Form - PersPerson.name - instructions',true)
					));

					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'AuthAuthor.reference_name',
						'label' => __('Form - PersPerson.reference_name',true),
						'instructions' => __('Form - PersPerson.reference_name - instructions',true)
					));

                echo $buro->einput();

				echo $buro->input(array(),array(
					'type' => 'text',
					'fieldName' => 'position',
					'label' => __('Form - PersPerson.position',true),
					'instructions' => __('Form - PersPerson.position - instructions',true)
				));

				echo $buro->input(array(),array(
					'type' => 'text',
					'fieldName' => 'lattes_link',
					'label' => __('Form - PersPerson.lattes_link',true),
					'instructions' => __('Form - PersPerson.lattes_link - instructions',true)
				));

				echo $buro->input(array(),array(
					'type' => 'textarea',
					'fieldName' => 'research_fields',
					'label' => __('Form - PersPerson.research_fields',true),
					'instructions' => __('Form - PersPerson.research_fields - instructions',true)
				));

				echo $buro->input(array(),array(
					'type' => 'textarea',
					'fieldName' => 'profile',
					'label' => __('Form - PersPerson.profile',true),
					'instructions' => __('Form - PersPerson.profile - instructions', true)
				));

				echo $buro->input(array(),array(
					'type' => 'textarea',
					'fieldName' => 'cooperation_with_dinafon',
					'label' => __('Form - PersPerson.cooperation_with_dinafon',true),
					'instructions' => __('Form - PersPerson.cooperation_with_dinafon - instructions',true)
				));
				
				
				echo $buro->sinput(
					array(),
					array(
						'label' => __('Form - PersPerson contact info superfield',true),
						'instructions' => __('Form - PersPerson contact info superfield - instructions',true),
						'type' => 'super_field'
					)
				);
					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'phone1',
						'label' => __('Form - PersPerson.phone1',true),
						'instructions' => __('Form - PersPerson.phone1 - instructions',true)
					));
					
					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'phone2',
						'label' => __('Form - PersPerson.phone2',true),
						'instructions' => __('Form - PersPerson.phone2 - instructions',true)
					));
					
					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'link1',
						'label' => __('Form - PersPerson.link1',true),
						'instructions' => __('Form - PersPerson.link1 - instructions',true)
					));
					
					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'link1_caption',
						'label' => __('Form - PersPerson.link1_caption',true),
						'instructions' => __('Form - PersPerson.link1_caption - instructions',true)
					));
					
					
					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'link2',
						'label' => __('Form - PersPerson.link2',true),
						'instructions' => __('Form - PersPerson.link2 - instructions',true)
					));
					
					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'link2_caption',
						'label' => __('Form - PersPerson.link2_caption',true),
						'instructions' => __('Form - PersPerson.link2_caption - instructions',true)
					));
					
					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'link3',
						'label' => __('Form - PersPerson.link3',true),
						'instructions' => __('Form - PersPerson.link3 - instructions',true)
					));
					
					
					echo $buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'link3_caption',
						'label' => __('Form - PersPerson.link3_caption',true),
						'instructions' => __('Form - PersPerson.link3_caption - instructions',true)
					));
				
				echo $buro->einput();
				
			
				echo $buro->submitBox(array(),array('publishControls' => true));
			echo $buro->eform();
		}
	break;
}

?>