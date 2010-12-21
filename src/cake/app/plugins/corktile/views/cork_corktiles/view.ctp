<?php
/*
 * This is a test view
 *  */
	echo $this->Bl->sdiv();
		$html_config = array();
		$options = array(
			'key' => 'outro',
			'type' => 'text',
			'title' => 'esse é o titulo',
			'location' => 'aqui a localização',
			'description' => 'aqui uma breve descrição',
			'id_content' => 1
		);


		$result = $this->CorkCork->tile($html_config, $options);
		echo $result;
	echo $this->Bl->ediv();

?>
