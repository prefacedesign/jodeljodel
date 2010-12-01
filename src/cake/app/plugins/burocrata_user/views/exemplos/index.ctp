<?php
	echo $this->Buro->sform(
		array('class' => 'azul'), // Parâmetros HTML
		array(
			'model' => 'BurocrataUser.Galery', // Somente o Model pai, assim como no FormHelper::create
			'callbacks' => array(
				'onStart'	=> array('lockForm'),
				'onComplete'=> array('unlockForm'),
				'onSave'    => array('popup' => 'Salvou!'),
				'onFailure'	=> array('popup' => 'Não foi possível conectar-se ao servidor!')
			),
			// 'url' => array('action' => 'recebedor') // Action que vai receber o POST
		)
	);
		
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
					// 'queryField' => 'User.name'
				)
			)
		);
		
		echo '<br />';
		echo '<br />';
		echo '<br />';
		echo '<br />';
		
		echo $this->Buro->submit(array(), array('label' => 'Send this :)'));
		
	echo $this->Buro->eform();
	
	
	
	
	echo '<div style="clear: both"></div>';
	echo '<br />';
	
	
	
	
	echo $this->Buro->sform(
			array(), 
			array(
				'model' => 'BurocrataUser.User',
				'writeForm' => true,
				'callbacks' => array(
					'onSave' => array('popup' => 'Salvou com sucesso'),
					'onFailure' => array('popup' => 'Não foi possível completar o request')
				)
			)
		);
	echo $this->Buro->eform();
	

	echo '<div style="clear: both"></div>';


/* 
	An autocomplete input
	
	echo $this->Buro->input(array(),
		array(
			'type' => 'autocomplete',
			'label' => 'User',
			'options' => array(
				'model' => 'BurocrataUser.User',
				'fieldName' => 'User.name',
				'callbacks' => array(
					'onSelect' => array('js' => "input.value = ''; alert(pair.value);"),
					'onSuccess' => array('popup' => 'Ahá!')
				)
			)
		)
	);

 */

/* 
	An auto-form that prints all that is needed.
	
	echo $this->Buro->form(
		array(),
		array(
			'model' => 'BurocrataUser.Local',
			'writeForm' => true,
			'callbacks' => array(
				'onStart' => array('lockForm'),
				'onComplete' => array('unlockForm'),
				'onSave'     => array('popup' => 'Salvou!'),
				'onRejected' => array('popup' => 'Não salvou!'),
				'onFailure'	 => array('popup' => 'Não foi possível conectar-se ao servidor!')
			)
		)
	);
*/
	
