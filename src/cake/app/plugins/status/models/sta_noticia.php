<?php

class StaNoticia extends StatusAppModel 
{	
	var $name = 'StaNoticia';
	var $useTable = 'noticias';
	//var $actsAs = array('Status.Status');
	
	
	var $actsAs = array(
  		'Status.Status' => array(
  			'status' => array(
 				//'field' => 'status',
 				'options' => array('rascunho', 'publicado'),
 				'active' => array('publicado')
 			)
 		)
	);
	
}

?>