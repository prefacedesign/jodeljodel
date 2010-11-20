<?php
	echo $this->Buro->sform(
		array('class' => 'azul'), // Parâmetros HTML
		array(
			'model' => 'Event', // Somente o Model pai, assim como no FormHelper::create
			'envio' => 'ajax',
			'callbacks' => array(
				'onStart' => array('js' => "form.setOpacity(0.5);"),
				'onComplete' => array('js' => "form.setOpacity(1);", 'popup' => 'Ahá!'),
				// 'onSuccess'  => array('redirect' => 'http://www.google.com'),
				'onSave'     => array('popup' => 'Salvou!'),
				'onRejected' => array('js' => "minhaFuncao(saved, response);")
			),
			'url' => array('action' => 'recebedor') // Action que vai receber o POST
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

	
