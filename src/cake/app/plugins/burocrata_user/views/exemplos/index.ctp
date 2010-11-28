<?php
	echo $this->Buro->sform(
		array('class' => 'azul'), // Parâmetros HTML
		array(
			'model' => 'BurocrataUser.Event', // Somente o Model pai, assim como no FormHelper::create
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
			'label' => 'About this event'
		));
		
			echo $this->Buro->input(
					array(), 
					array('fieldName' => 'begin', 'label' => 'When it begins?', 'type' => 'text')
				);
			
			
			echo $this->Buro->input(
					array(), 
					array('fieldName' => 'end', 'label' => 'When it ends?', 'type' => 'text')
				);
			
			echo $this->Buro->input(
					array(), 
					array('fieldName' => 'about', 'type' => 'textarea')
				);
			
		echo $this->Buro->einput();
		
		// echo $this->Buro->input(
			// array(),
			// array(
				// 'type' => 'belongs_to',
				// 'label' => 'Local of event',
				// 'instructions' => 'Find the local of event by its name or create a new one.',
				// 'options' => array(
					// 'assocName' => 'Local',
					// 'queryField' => 'Local.name',
					// 'type' => 'autocomplete'
				// )
			// )
		// );
		
		echo $this->Buro->submit(array(), array('label' => 'Send this :)'));
		
	echo $this->Buro->eform();
	
	echo '<div style="clear: both"></div>';
	
	
	echo $this->Buro->input(array(),
		array(
			'type' => 'autocomplete',
			'label' => 'Local of event',
			'options' => array(
				'model' => 'BurocrataUser.Local',
				'fieldName' => 'Local.name',
				'callbacks' => array(
					'onSelect' => array('js' => "input.value = ''; alert(pair.value);"),
					'onSuccess' => array('popup' => 'Ahá!')
				)
			)
		)
	);
	
	
	echo $this->Buro->input(array(),
		array(
			'type' => 'autocomplete',
			'label' => 'Local of event',
			'options' => array(
				'model' => 'BurocrataUser.Hash',
				'fieldName' => 'Local.name',
				'callbacks' => array(
					'onSelect' => array('js' => "input.value = ''; alert(pair.value);")
				)
			)
		)
	);



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
	
