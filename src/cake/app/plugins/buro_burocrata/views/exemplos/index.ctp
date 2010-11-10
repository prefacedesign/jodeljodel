<?php
	echo $this->BuroBurocrata->input(
			array(),
			array(
				'name' => 'titulo',
				'label' => 'Título',
				'type' => 'text',
				'instructions' => 'Lorem ipsum dolor eler sit.'
			)
		);
		
	echo $this->BuroBurocrata->iinput(
			array(),
			array(
				'label' => 'Detalhes',
				'type' => 'super_field'
			)
		);
	
		echo $this->BuroBurocrata->input(
				array(),
				array(
					'name' => 'descricao',
					'label' => 'Descrição',
					'type' => 'textarea', 
					'instructions' => 'Descreva em poucas palavras... patatí...'
				)
			);
		echo $this->BuroBurocrata->input(
				array(), 
				array(
					'name' => 'gosta_da_gente',
					'label' => 'Você gosta da gente?',
					'type' => 'text',
					'instructions' => 'Seja sincero. Por favor.'
				)
			);
	
	echo $this->BuroBurocrata->finput();
	
	echo "\n";
	
	echo $this->BuroBurocrata->iform(
			array('class' => 'azul'), // Parâmetros HTML
			array(
				'model' => 'Noticia', // Somente o Model pai, assim como no FormHelper::create
				'envio' => 'ajax',
				'auto_submit' => true, // Não tenho certeza o que isso faz
				'url' => array('action' => 'recebedor') // Action que vai receber o POST
			)
		);
		
		
		echo $this->BuroBurocrata->input(
				array(), 
				array(
					'name' => 'teste',
					'label' => 'Isso é um teste?',
					'type' => 'text'
				)
			);
		
		echo $this->BuroBurocrata->input(
			array(),
			array(
				'type' => 'belongs_to',
				'association' => 'Periodico',
				'options' => array(
					'type' => 'autocomplete', 
					'allow' => array('link', 'insert', 'modify')
				)
			)
		);
		
	echo $this->BuroBurocrata->fform();

	
