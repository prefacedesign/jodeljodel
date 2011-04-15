<?php

	//debug($this->data);
	
	echo $this->Buro->sform(array('class' => 'azul'), // Parâmetros HTML
		array(
			'model' => 'BurocrataUser.Video', // Somente o Model pai, assim como no FormHelper::create
			'callbacks' => array(
				'onStart'	=> array('lockForm'),
				'onComplete'=> array('unlockForm'),
				'onSuccess' => array('contentUpdate' => 'replace'),
				'onSave'    => array('popup' => 'Salvou a gabaça'),
				'onError'   => array('js' => "if(code == E_NOT_JSON) alert('Não é json! Não é json!'); else alert(error);"),
				'onFailure'	=> array('popup' => 'Erro de comunicação com o servidor!')
			)
		)
	);
	
		echo $this->Buro->input(array(),
			array(
				'label' => 'Video id',
				'fieldName' => 'Video.id',
				'type' => 'hidden'
			)
		);
		
		echo $this->Buro->input(array(),
			array(
				'label' => 'Video title',
				'fieldName' => 'Video.title'
			)
		);
		
		echo $this->Buro->input(array(), 
			array(
				'type' => 'tags',
				'label' => 'Owner',
				'instructions' => 'Selecione um ou mais',
				'fieldName' => 'tags', // default tags
				'options' => array(
					'type' => 'comma', // (default comma)
				)
			)
		);
		
		
		echo $this->Buro->input(array(), 
			array(
				'type' => 'relational',
				'label' => 'Owner',
				'instructions' => 'Selecione um ou mais',
				'fieldName' => 'Person',
				'options' => array(
					'type' => 'list', // Former belongsTo, that now is also hasOne
					'multiple' => true,
					'size' => 3,
					'model' => 'Person',
				)
			)
		);
		
		
		echo $this->Buro->submit();
		
	echo $this->Buro->eform();

	
