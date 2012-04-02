<?php

echo $this->Bl->sbox(array(),array('size' => array('M' => 12, 'g' => -1)));
	echo $this->Bl->h1Dry($sectionInfo['humanName']);
echo $this->Bl->ebox();

echo $this->Bl->sbox(array(),array('size' => array('M' => 7, 'g' => -1)));
	echo $this->Buro->sform(array(), 
		array(
			'model' => 'JjUsers.UserUser',
			'url' => $this->here
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
echo $this->Bl->ebox();
