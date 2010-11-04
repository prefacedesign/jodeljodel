<?php
	echo $buroBurocrata->input(
			array(),
			array(
				'name' => 'titulo',
				'label' => 'Título',
				'type' => 'text',
				'instructions' => 'Lorem ipsum dolor eler sit.'
			)
		);
		
	echo $buroBurocrata->iinput(
			array(),
			array(
				'label' => 'Detalhes',
				'type' => 'super_field'
			)
		);
	
		echo $buroBurocrata->input(
				array(),
				array(
					'name' => 'descricao',
					'label' => 'Descrição',
					'type' => 'textarea', 
					'instructions' => 'Descreva em poucas palavras... patatí...'
				)
			);
		echo $buroBurocrata->input(
				array(), 
				array(
					'name' => 'gosta_da_gente',
					'label' => 'Você gosta da gente?',
					'type' => 'text',
					'instructions' => 'Seja sincero. Por favor.'
				)
			);
	
	echo $buroBurocrata->finput();

	
