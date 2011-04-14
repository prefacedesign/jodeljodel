<?php

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
				'label' => 'Video title',
				'fieldName' => 'Video.title'
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
					'model' => 'Person',
					//'conditions' => array('Person.id' => 1)
				)
			)
		);
		
		
		echo $this->Buro->submit();
	echo $this->Buro->eform();