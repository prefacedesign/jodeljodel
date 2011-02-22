<?php
/*
 * This is a test view
 *  */
	echo $this->Bl->sdiv();
		$html_config = array();
		$options = array(
			'key' => 'another_strange_key',
			'type' => 'text_cork',
			'title' => 'esse é o titulo',
			'location' => array('Sobre','História do Museu'),
			'defaultContent' => array('TextTextCork' =>
				array('text' => "This content hasn't been written yet")
			),
			'editorsRecommendations' => 'aqui uma breve descrição',
			'options' => array('textile' => true, 'convert_links' => true)
		);
		echo $this->Cork->tile($html_config, $options);
	echo $this->Bl->ediv();

?>
