<?php
	echo $this->BuroBurocrata->iform(
			array('class' => 'azul'), // Parâmetros HTML
			array(
				'model' => 'Event', // Somente o Model pai, assim como no FormHelper::create
				'envio' => 'ajax',
				'auto_submit' => true, // Não tenho certeza o que isso faz
				'url' => array('action' => 'recebedor') // Action que vai receber o POST
			)
		);
		
		echo $this->BuroBurocrata->iinput(array(),array(
			'type' => 'super_field',
			'label' => 'About this event'
		));
		
			echo $this->BuroBurocrata->input(
					array(), 
					array('name' => 'begin', 'label' => 'When it begins?', 'type' => 'datetime')
				);
			
			
			echo $this->BuroBurocrata->input(
					array(), 
					array('name' => 'end', 'label' => 'When it ends?', 'type' => 'datetime')
				);
			
			echo $this->BuroBurocrata->input(
					array(), 
					array('name' => 'about', 'type' => 'textarea')
				);
			
		
		echo $this->BuroBurocrata->finput();
		
		echo $this->BuroBurocrata->input(
			array(),
			array(
				'type' => 'belongs_to',
				'label' => 'Local of event',
				'instructions' => 'Find the local of event by its name or create a new one.',
				'options' => array(
					'model' => 'Local',
					'type' => 'autocomplete',
					'allow' => array('create', 'modify')
				)
			)
		);
		
		// echo $this->BuroBurocrata->input(
			// array(),
			// array(
				// 'type' => 'has_many',
				// 'association' => 'Fonte'
			// )
		// );
		
	echo $this->BuroBurocrata->fform();

	
