<?php
	
	echo $this->Bl->sbox(array(),array('size' => array('M' => 7, 'g' => -1)));
	
	echo $this->Buro->sform(array('class' => 'azul'), // Parâmetros HTML
		array(
			'model' => 'BurocrataUser.Document', // Somente o Model pai, assim como no FormHelper::create
			'callbacks' => array(
				'onStart'	=> array('lockForm'),
				'onComplete'=> array('unlockForm'),
				'onSave'    => array('popup' => 'Salvou a gabaça'),
				'onError'   => array('js' => "if(code == E_NOT_JSON) alert('Não é json! Não é json!'); else if(code == E_JSON) alert(error); else if(code == E_NOT_AUTH) alert('Você não tem autorização para isso.');"),
				'onFailure'	=> array('popup' => 'Erro de comunicação com o servidor!'),
			)
		)
	);
	
		echo $this->Buro->input(
			array(),
			array(
				'type' => 'text',
				'fieldName' => 'name',
				'label' => __d('buro_user', 'Document title', true)
			)
		);
		
		echo $this->Buro->input(
			array(),
			array(
				'type' => 'content_stream',
				'instructions' => __d('buro_user', 'Instructions for content_stream', true),
				'label' => __d('buro_user', 'Document body', true)
			)
		);
		
		echo $this->Buro->submit();
	
	echo $this->Buro->eform();

echo $this->Bl->ebox();
