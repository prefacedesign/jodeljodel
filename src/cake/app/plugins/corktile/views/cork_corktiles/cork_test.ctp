<?php
/*
 * This is a test view
 *  */
	echo $this->Bl->sdiv();
		$html_config = array();
		$options = array(
			'key' => 'chave_mirabolante',
			'type' => 'text_cork',
			'title' => 'esse é o titulo',
			'location' => array('aqui a localização'),
			'defaultContent' => array('TextTextCork' =>
				array('text' => 'Obladi oblada, lalalala')
			),
			'editorsRecommendations' => 'aqui uma breve descrição',
			'options' => array('textile' => true, 'convert_links' => true)
		);
		echo $this->Cork->tile($html_config, $options);
	echo $this->Bl->ediv();

?>
