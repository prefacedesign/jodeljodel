<?php

echo $this->Buro->sform(array(),
	array(
		'model' => 'BurocrataUser.User',
		'callbacks' => array(
			'onStart'	=> array('lockForm'),
			'onComplete'=> array('unlockForm'),
			'onSave'    => array('js' => "BuroClassRegistry.get('$baseID').onSave();"),
			'onReject'  => array('popup' => 'Existe algum erro de validação.'),
			'onError'   => array('js' => "if(code == E_NOT_JSON) alert('Não é json! Não é json!'); else alert(error);"),
			'onFailure'	=> array('popup' => 'Erro de comunicação com o servidor!')
		)
	)
);
	echo $this->Buro->input(
		array(),
		array('fieldName' => 'id', 'type' => 'hidden')
	);
	
	echo $this->Buro->input(
		array(),
		array('fieldName' => 'name')
	);
	
	echo $this->Buro->input(
		array(),
		array('fieldName' => 'age')
	);
	
	echo $this->Buro->input(
		array(),
		array(
			'fieldName' => 'gender',
			'type' => 'radio',
			'options' => array(
				'legend' => false,
				'options' => array('male' => 'Male', 'female' => 'Female')
			)
		)
	);

	echo $this->Buro->submit();
echo $this->Buro->eform();