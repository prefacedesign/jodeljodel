<?php

Configure::write('Media.filter_plus.olimpiada_equipe', array(
	'fields' => array('Equipe.imagem_id'),
	'image' => array(
		'sala'  => array('fit' => array(600, 440)),
		'lista' => array('fitCrop' => array(150, 50))
	)
));

Configure::write('Media.filter_plus.olimpiada_documento', array(
	'fields' => array('Documento.imagem_id'),
	'image' => array(
		'preview' => array('fit' => array(200, 250)),
		'view'    => array('fit' => array(400, 400)),
		'lista'   => array('fit' => array(100, 100))
	)
));