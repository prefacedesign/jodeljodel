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
							'model' => 'Paper.JourJournal',
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
							'fieldName' => 'JourJournal.id'
						));
						echo $buro->input(array(),array(
							'type' => 'text',
							'fieldName' => 'JourJournal.full_name',
							'label' => __('Form - JourJournal.full_name',true),
							'instructions' => __('Form - JourJournal.full_name - instructions',true)
						));

						echo $buro->input(array(),array(
							'type' => 'text',
							'fieldName' => 'JourJournal.short_name',
							'label' => __('Form - JourJournal.short_name',true),
							'instructions' => __('Form - JourJournal.short_name - instructions',true)
						));

						echo $buro->input(array(),array(
							'type' => 'text',
							'fieldName' => 'JourJournal.link',
							'label' => __('Form - JourJournal.link',true),
							'instructions' => __('Form - JourJournal.link - instructions',true)
						));

						echo $this->Buro->submit();						
					echo $this->Buro->eform();
				break;
				case 'view':
				case 'belongs_to_preview':
					echo $this->Bl->b(array(), array(), __('Form - JourJournal.full_name - belongsTo label',true));
					echo $this->Bl->p(array(), array(), $data['JourJournal']['full_name']);
					
					echo $this->Bl->b(array(), array(), __('Form - JourJournal.short_name - belongsTo label',true));
					echo $this->Bl->p(array(), array(), $data['JourJournal']['short_name']);
					
					echo $this->Bl->b(array(), array(), __('Form - JourJournal.link	- belongsTo label',true));
					echo $this->Bl->p(array(), array(), $data['JourJournal']['link']);
				break;
			}
		break;
	}