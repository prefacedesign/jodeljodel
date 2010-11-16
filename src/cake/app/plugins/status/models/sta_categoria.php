<?php

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