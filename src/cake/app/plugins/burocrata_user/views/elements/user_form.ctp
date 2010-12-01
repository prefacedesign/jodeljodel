<?php
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
	
	echo '<div style="clear: both"></div>';