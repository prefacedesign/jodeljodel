<?php
	echo $this->Buro->sinput(array(),array(
		'type' => 'super_field',
		'label' => 'About this galery'
	));
	
		echo $this->Buro->input(
				array(), 
				array('fieldName' => 'title')
			);
		
		echo $this->Buro->input(
				array(), 
				array(
					'fieldName' => 'date',
					'type' => 'datetime',
					'options' => array(
						'dateFormat' => 'DMY',
						'timeFormat' => null
					)
				)
			);
		
		
		
		echo $this->Buro->input(
				array(), 
				array('fieldName' => 'about', 'type' => 'textarea')
			);
		
	echo $this->Buro->einput();
	
	echo $this->Buro->input(
		array(),
		array(
			'type' => 'belongs_to',
			'label' => 'Owner',
			'instructions' => 'Find the user by his/her name or register a new one right here, right now!',
			'options' => array(
				'type' => 'autocomplete',
				'model' => 'BurocrataUser.User',
				// 'queryField' => 'User.name',
				'callbacks' => array(
					'onSelect' => array('js' => 'this.input.value = pair.value')
				)
			)
		)
	);
	
	echo '<br />';
	echo '<br />';
	echo '<br />';
	echo '<br />';
	
	echo $this->Buro->submit(array(), array('label' => 'Send this :)'));