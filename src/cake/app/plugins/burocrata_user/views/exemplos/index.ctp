<?php
	echo $this->Buro->sform(
		array('class' => 'azul'), // Parâmetros HTML
		array(
			'model' => 'BurocrataUser.Event', // Somente o Model pai, assim como no FormHelper::create
			'callbacks' => array(
				'onStart' => array('lockForm', 'js' => "console.log('iniciou-se')"),
				'onComplete' => array('unlockForm', 'js' => "console.log('finalizou-se')"),
				// 'onSuccess'  => 'contentUpdate',
				'onSave'     => array('popup' => 'Salvou!'),
				'onRejected' => array('js' => "console.log('aqui estou');"),
				'onFailure'	 => array('popup' => 'Não foi possível conectar-se ao servidor!')
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
		
		echo $this->Buro->submit(array(), array('label' => 'Send this :)'));
		
	echo $this->Buro->eform();
	
 	echo $this->Buro->sform(
		array(),
		array(
			'model' => 'BurocrataUser.Local', // Somente o Model pai, assim como no FormHelper::create
			'callbacks' => array(
				'onStart' => array('lockForm'),
				'onComplete' => array('unlockForm'),
				'onSave'     => array('popup' => 'Salvou!'),
				'onRejected' => array('popup' => 'Não salvou!'),
				'onFailure'	 => array('popup' => 'Não foi possível conectar-se ao servidor!')
			)
		)
	);
		echo $this->Buro->input(
				array(), 
				array('fieldName' => 'name', 'label' => 'Name?', 'type' => 'text')
			);
		
		echo $this->Buro->input(
				array(), 
				array('fieldName' => 'address', 'label' => 'Address?', 'type' => 'textarea')
			);
			
		echo $this->Buro->submit(array(), array('label' => 'Send this :)'));
		
	echo $this->Buro->eform(); 
	
		// echo $this->Buro->input(
			// array(),
			// array(
				// 'type' => 'belongs_to',
				// 'label' => 'Local of event',
				// 'instructions' => 'Find the local of event by its name or create a new one.',
				// 'options' => array(
					// 'model' => 'Local',
					// 'type' => 'autocomplete',
					// 'allow' => array('create', 'modify')
				// )
			// )
		// );
		
	// echo $this->Buro->eform();

	
