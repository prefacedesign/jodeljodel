<?php
	if(!isset($type)) $type = array(null);
	if(!is_array($type)) $type = array($type);
	
	switch($type[0])
	{
		case 'admin_form':
			echo $this->element('user_form', array('plugin' => 'burocrata_user'));
		break;
		
		case 'buro':
			switch($type[1])
			{
				case 'form':
				case 'admin_form':
				case 'subform':
				case 'belongsto_form':
					echo $this->element('person_form', array('plugin' => 'burocrata_user'));
				break;
				
				case 'view':
				case 'admin_view':
				case 'preview':
				case 'belongsto_preview':
					echo $this->Bl->bDry(__d('buro_user', 'Name: ', true));
					echo $this->Bl->pDry($data['Person']['name']);
					
					$now = strtotime('now');
					$birthday = strtotime($data['Person']['birthdate']);
					$age = 0;
					while($now > $birthday = strtotime('+1 year', $birthday))
						++$age;
					
					echo $this->Bl->bDry(__d('buro_user', 'Birthday: ', true));
					echo $this->Bl->pDry($data['Person']['birthdate'] . ' (' . $age . ' years)');
					
					echo $this->Bl->bDry(__d('buro_user', 'Number of galleries: ', true));
					echo $this->Bl->pDry($data['Person']['galery_count']);
					
					echo '<br />';
				break;
			}
		break;
	}
