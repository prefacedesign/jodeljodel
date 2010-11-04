<?php

class Produto extends StastatusAppModel 
{	
	var $name = 'Produto';
	
	var $actsAs = array(
		'Stastatus.StaStatus' => array('disponibilidade', 'etapa')
	);
	
	
	/*
	var $actsAs = array(
		'Stastatus.StaStatus' => array('rascunhavel','etapa')
	);
	*/
	
	
}

?>