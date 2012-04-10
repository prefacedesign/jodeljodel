<?php

switch ($type[0])
{
	case 'buro':
		switch ($type[1])
		{
			case 'form':
				echo $this->Buro->sform(array(), 
					array(
						'model' => 'JjUsers.UserUser',
						'url' => $this->here,
						'callbacks' => array(
							'onSave' => array('contentUpdate' => 'replace', 'js' => 'showPopup("notice")'),
							'onReject' => array('contentUpdate' => 'replace', 'js' => 'showPopup("error")')
						)
					)
				);

					echo $this->Buro->sinput(
						array(),
						array(
							'type' => 'super_field',
							'label' => __d('jj_users', 'name_surname super_field label', true),
							'instructions' => __d('jj_users', 'name_surname super_field instructions', true)
						)
					);
	
						echo $this->Buro->input(
							array(),
							array(
								'fieldName' => 'name',
								'type' => 'text',
								'label' => __d('jj_users', 'name label', true),
								'instructions' => __d('jj_users', 'name instructions', true)
							)
						);
	
						echo $this->Buro->input(
							array(),
							array(
								'fieldName' => 'surname',
								'type' => 'text',
								'label' => __d('jj_users', 'surname label', true),
								'instructions' => __d('jj_users', 'surname instructions', true)
							)
						);
			
	
					echo $this->Buro->einput();
		
					echo $this->Buro->sinput(
						array(),
						array(
							'type' => 'super_field',
							'label' => __d('jj_users', 'account super_field label', true),
							'instructions' => __d('jj_users', 'account super_field instructions', true)
						)
					);
		
						echo $this->Buro->input(
							array(),
							array(
								'fieldName' => 'username',
								'type' => 'text',
								'label' => __d('jj_users', 'username label', true),
								'instructions' => __d('jj_users', 'username instructions', true)
							)
						);
			
						echo $this->Buro->input(
							array(),
							array(
								'fieldName' => 'password_change',
								'type' => 'text',
								'label' => __d('jj_users', 'password_change label', true),
								'instructions' => __d('jj_users', 'password_change instructions', true)
							)
						);
			
						echo $this->Buro->input(
							array(),
							array(
								'fieldName' => 'password_retype',
								'type' => 'text',
								'label' => __d('jj_users', 'password_retype label', true),
								'instructions' => __d('jj_users', 'password_retype instructions', true)
							)
						);
					echo $this->Buro->einput();
		
					echo $this->Buro->submitBox(
						array(),
						array(
							'submitLabel' => __d('jj_users', 'submit label', true)
						)
					);
		
				echo $this->Buro->eform();
			break;
		
			
		
			default:
				# code...
			break;
		}
	break;
}
