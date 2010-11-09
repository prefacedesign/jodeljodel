<?php

class Noticia extends StastatusAppModel 
{	
	var $name = 'Noticia';
	//var $actsAs = array('Stastatus.StaStatus');
	
	
	var $actsAs = array(
  		'Stastatus.StaStatus' => array(
  			'status' => array(
 				//'field' => 'status',
 				'options' => array('rascunho', 'publicado'),
 				'active' => array('publicado')
 			)
 		)
	);
	
}

?>