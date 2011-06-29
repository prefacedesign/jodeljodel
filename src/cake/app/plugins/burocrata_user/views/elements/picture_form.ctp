<?php
echo $this->Buro->sform(
	array(), 
	array('model' => 'BurocrataUser.Picture')
);

	echo $this->Buro->input(
		array('value' => $baseID, 'name' => $this->Buro->internalParam('baseID')),
		array('type' => 'hidden')
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
			'options' => array(
				'version' => 'backstage_preview'
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