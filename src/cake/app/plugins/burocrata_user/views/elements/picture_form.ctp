<?php
echo $this->Buro->sform(array(), 
	array(
		'model' => 'BurocrataUser.Picture',
		'callbacks' => array(
			'onStart'	=> array('lockForm'),
			'onComplete'=> array('unlockForm'),
			'onSave'    => array('js' => "BuroClassRegistry.get('$baseID').saved(json.saved);"),
			'onCancel'	=> array('js' => "BuroClassRegistry.get('$baseID').cancel();"),
			'onReject'  => array('contentUpdate', 'popup' => 'Existe algum erro de validação.'),
			'onFailure'	=> array('popup' => 'Erro de comunicação com o servidor!')
		)
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
		array('fieldName' => 'title')
	);
	
	echo $this->Buro->input(
		array(),
		array(
			'type' => 'image',
			'fieldName' => 'file_upload_id',
			'version' => 'backstage_preview'
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