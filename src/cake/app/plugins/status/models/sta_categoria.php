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


class StaCategoria extends StatusAppModel 
{	
	var $name = 'StaCategoria';
	var $useTable = 'categorias';
	
	var $hasMany = array('Aluno');
	
	var $actsAs = array(
  		'Status.Status' => array(
  			'status' => array(
 				'options' => array('ativo', 'inativo'),
 				'active' => array('ativo')
 			)
 		)
	);
	
	
}

?>