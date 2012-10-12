<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

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
