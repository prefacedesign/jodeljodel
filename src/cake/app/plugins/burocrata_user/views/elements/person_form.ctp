<?php

echo $this->Buro->sform(array(),
	array(
		'model' => 'BurocrataUser.Person'
	)
);
	
	echo $this->Buro->input(
		array(),
		array('fieldName' => 'id', 'type' => 'hidden')
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
	
	echo $this->Buro->input(
		array(),
		array('fieldName' => 'name')
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