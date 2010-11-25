<?php
echo $this->Buro->input(
		array(), 
		array('fieldName' => 'name', 'label' => 'Name', 'type' => 'text')
	);

echo $this->Buro->input(
		array(), 
		array('fieldName' => 'address', 'label' => 'Address', 'type' => 'textarea')
	);