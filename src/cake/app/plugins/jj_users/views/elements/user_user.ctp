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

					echo $this->Buro->input(
						array(), 
						array(
							'fieldName' => 'id',
							'type' => 'hidden'
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
								'type' => 'text'
							)
						);
	
						echo $this->Buro->input(
							array(),
							array(
								'fieldName' => 'surname',
								'type' => 'text'
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
								'type' => 'text'
							)
						);
			
						echo $this->Buro->input(
							array(),
							array(
								'fieldName' => 'password_change',
								'type' => 'text'
							)
						);
			
						echo $this->Buro->input(
							array(),
							array(
								'fieldName' => 'password_retype',
								'type' => 'text'
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
