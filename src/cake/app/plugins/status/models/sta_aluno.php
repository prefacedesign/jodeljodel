<?php

class StaAluno extends StatusAppModel 
{	
	var $name = 'StaAluno';
	var $useTable = 'alunos';
	var $belongsTo = 'Categoria'; 
	
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