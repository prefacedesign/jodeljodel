<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */


class StaNoticia extends StatusAppModel 
{	
	var $name = 'StaNoticia';
	var $useTable = 'noticias';
	var $actsAs = array('Status.Status');
	
	/*
	var $actsAs = array(
  		'Status.Status' => array(
			'tamanho' => array(
				'field' => 'status2'
			)
		)
	);
	*/
	
	/*
	var $actsAs = array(
  		'Status.Status' => array(
  			'status' => array(
 				//'field' => 'status',
 				'options' => array('rascunho', 'publicado'),
 				'active' => array('publicado')
 			)
 		)
	);
	*/
	
}

?>