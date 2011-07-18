<?php

echo $this->Buro->sform(array(),
	array(
		'model' => 'BurocrataUser.Person',
		// 'callbacks' => array(
			// 'onStart'	=> array('lockForm'),
			// 'onComplete'=> array('unlockForm'),
			// 'onReject'  => array('contentUpdate', 'popup' => 'Existe algum erro de validação.'),
			// 'onFailure'	=> array('popup' => 'Erro de comunicação com o servidor!')
		// )
	)
);
	echo $this->Bl->input(
		array('value' => $baseID, 'name' => $this->Buro->internalParam('baseID'), 'type' => 'hidden')
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
		array(
			'fieldName' => 'birthdate', 
			'type' => 'datetime', 
			'options' => array(
				'dateFormat' => 'DMY',
				'timeFormat' => null,
				'minYear' => date('Y')-100,
				'maxYear' => date('Y'),
			)
		)
	);

	echo $this->Buro->submit(
		array(), 
		array(
			'label' => 'Salva',
			'cancel' => array(
				'label' => 'Cancelar'
			)
		)
	);
echo $this->Buro->eform();
echo $this->Bl->floatBreak();