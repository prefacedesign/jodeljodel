<?php


switch($type[0])
	{
		case 'admin_form':
			echo $this->element('user_form', array('plugin' => 'burocrata_user'));
		break;
		
		case 'buro':
			switch($type[1])
			{
				case 'form':
				case 'belongs_to_form':
					echo $this->Buro->sform(array(),
						array(
							'model' => 'Author.AuthAuthor',
							'callbacks' => array(
								'onStart'	=> array('lockForm'),
								'onComplete'=> array('unlockForm'),
								'onSave'    => array('js' => "BuroClassRegistry.get('$baseID').saved(json.saved);"),
								'onReject'  => array('contentUpdate', 'popup' => 'Existe algum erro de validação.'),
								'onError'   => array('js' => "if(code == E_NOT_JSON) alert('Não é json! Não é json!'); else alert(error);"),
								'onFailure'	=> array('popup' => 'Erro de comunicação com o servidor!')
							)
						)
					);
						echo $this->Bl->input(
							array('value' => $baseID, 'name' => $this->Buro->internalParam('baseID'), 'type' => 'hidden')
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

						echo $this->Buro->submit();						
					echo $this->Buro->eform();
				break;
				case 'view':
				case 'belongs_to_preview':
					echo $this->Bl->b(array(), array(), 'Name: ');
					echo $this->Bl->p(array(), array(), $data['AuthAuthor']['name']);
					
					echo $this->Bl->b(array(), array(), 'Surnmae: ');
					echo $this->Bl->p(array(), array(), $data['AuthAuthor']['surname']);
					
					echo $this->Bl->b(array(), array(), 'Reference Name: ');
					echo $this->Bl->p(array(), array(), $data['AuthAuthor']['reference_name']);
				break;
			}
		break;
	}