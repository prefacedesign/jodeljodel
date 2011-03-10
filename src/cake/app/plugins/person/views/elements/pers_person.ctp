<?php

switch ($type[0])
{
	case 'mini_preview':
			echo $this->Bl->h4(array(), array(), $this->Bl->anchor(array(),array('url' => array('plugin' => 'person', 'controller' => 'pers_people', 'action' => 'view', $data['PersPerson']['id'])),
				$data['AuthAuthor']['name'] . ' ' . $data['AuthAuthor']['surname']));
			echo $this->Bl->para(
				array(),
				array(),
				array(
					__('pers_person element: research_fields caption',true).':&ensp;'
					. $this->Bl->span(array ('class' => 'italico'), array(), $data['PersPerson']['research_fields'])
				)
			);
	break;
	
	case 'preview':
		echo $this->Bl->h4(array(),array(),$this->Bl->anchor(
				array(), 
				array(
					'url' => array(
						'plugin' => 'person', 
						'controller' => 'pers_people', 
						'action' => 'view', 
						$data['PersPerson']['id']
					)
				), 
				$data['AuthAuthor']['name'] . ' ' . $data['AuthAuthor']['surname']
			)
		);
		
		
		$exploden = explode(' ', $data['PersPerson']['cooperation_with_dinafon'], 36);
		if (isset($exploden[35]))
			unset($exploden[35]);
		$cooperation_with_dinafon = implode(' ', $exploden) . '...';
		
		echo $this->Bl->paraDry(
			array(
				__('pers_person element: research_fields caption',true).'&ensp;'
				. $this->Bl->span(array('class' => 'italico'), array(), $data['PersPerson']['research_fields'])
			)
		);
		
		echo $this->Bl->paraDry(
			array(
				__('pers_person element: cooperation_with_dinafon caption',true) . '&ensp;'
				. $this->Bl->span(array('class' => 'italico'), array(), $cooperation_with_dinafon)
			)
		);
	break;
	
	case 'full':
		echo $this->Bl->scoluna(array('class' => 'person_info'), array('size' => array('M' => 8)));	
			echo $this->Bl->img(array('class' => 'person_img'), array('id' => $data['PersPerson']['img_id'], 'version' => 'preview'));
			echo $this->Bl->h2(array(),array(),$data['AuthAuthor']['name']);
			echo $this->Bl->paraDry(array($data['PersPerson']['position']));
			echo $this->Bl->scoluna(array(), array('size' => array('M' => 4)));	
				echo $this->Bl->h4(array(),array(),__('pers_person element: research_fields caption',true));
				echo $this->Bl->paraDry(array($data['PersPerson']['research_fields']));
				echo $this->Bl->paraDry(array($this->Bl->anchor(array(), array('url' => $data['PersPerson']['lattes_link']),__('pers_person element: link_lattes caption',true))));
			echo $this->Bl->ecoluna();
		echo $this->Bl->ecoluna();
		echo $this->Bl->barraHorizontal(array('class' => 'cinza_branco'));		
		echo $this->Bl->floatBreak();
		
		echo $this->Bl->scoluna(array(), array('size' => array('M' => 5)));
			echo $this->Bl->scoluna(array(), array('size' => array('M' => 4)));
				echo $this->Bl->h4(array(),array(),__('pers_person element: cooperation_with_dinafon caption',true));				
				echo $this->Bl->paraDry(array($data['PersPerson']['cooperation_with_dinafon']));		
			echo $this->Bl->ecoluna();
		echo $this->Bl->ecoluna();
		echo $this->Bl->scoluna(array(), array('size' => array('M' => 3)));
			echo $this->Bl->h4(array(),array(),__('pers_person element: profile caption',true));
			echo $this->Bl->paraDry(array($data['PersPerson']['profile']));
			if (!empty($data['PersPerson']['phone1']) || !empty($data['PersPerson']['phone2']))
				echo $this->Bl->h4(array(),array(),__('pers_person element: contact caption',true));
			
			$a = '';
			if (!empty($data['PersPerson']['phone1']))
			{
				$a = $data['PersPerson']['phone1'];
				$a .= '<br />';
			}
			if (!empty($data['PersPerson']['phone2']))
				$a = $data['PersPerson']['phone2'];
			echo $this->Bl->paraDry(array($a));
			
			if (!empty($data['PersPerson']['link1']) || !empty($data['PersPerson']['link2']) || !empty($data['PersPerson']['link3']))
				echo $this->Bl->h4(array(),array(),__('pers_person element: internet caption',true));
			$a = '';
			if (!empty($data['PersPerson']['link1']))
			{
				if (!empty($data['PersPerson']['link1_caption']))
					$a = $this->Bl->anchor(array(), array('url' => $data['PersPerson']['link1']),$data['PersPerson']['link1_caption']);
				else
					$a = $this->Bl->anchor(array(), array('url' => $data['PersPerson']['link1']),$data['PersPerson']['link1']);
				$a .= '<br />';
			}
			if (!empty($data['PersPerson']['link2']))
			{
				if (!empty($data['PersPerson']['link2_caption']))
					$a .= $this->Bl->anchor(array(), array('url' => $data['PersPerson']['link2']),$data['PersPerson']['link2_caption']);
				else
					$a .= $this->Bl->anchor(array(), array('url' => $data['PersPerson']['link2']),$data['PersPerson']['link2']);
				$a .= '<br />';
			}
			if (!empty($data['PersPerson']['link3']))
			{
				if (!empty($data['PersPerson']['link3_caption']))
					$a .= $this->Bl->anchor(array(), array('url' => $data['PersPerson']['link3']),$data['PersPerson']['link3_caption']);
				else
					$a .= $this->Bl->anchor(array(), array('url' => $data['PersPerson']['link3']),$data['PersPerson']['link3']);
				$a .= '<br />';
			}
			echo $this->Bl->paraDry(array($a));
		echo $this->Bl->ecoluna();
		
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
					'type' => 'image',
					'fieldName' => 'img_id',
					'label' => __('Form - PersPerson.img_id',true),
					'instructions' => __('Form - PersPerson.img_id - instructions',true),
					'options' => array('version' => 'backstage_preview')
				));
				
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
				
				/*echo $buro->input(array(),array(
					'type' => 'image',
					'fieldName' => 'img_id',
					'label' => __('Form - PersPerson.img_id',true),
					'instructions' => __('Form - PersPerson.img_id - instructions',true),
					'options' => array('version' => 'backstage_preview')
				));*/
				
				echo $buro->submitBox(array(),array('publishControls' => false));
			echo $buro->eform();
		}
	break;
	
}

?>