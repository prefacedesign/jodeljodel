<?php

class StaProduto extends StatusAppModel 
{	
	var $name = 'StaProduto';
	var $useTable = 'produtos';
	
	var $actsAs = array(
		'Status.Status' => array('disponibilidade', 'etapa')
	);
	
	
	/*
	var $actsAs = array(
		'Status.Status' => array('rascunhavel','etapa')
	);
	*/
	
	
}

?>