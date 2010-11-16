<?php

class TypeTesteController extends TypographerAppController
{
	var $name = 'Teste';
	var $layout = 'teste';
	var $layout_scheme = 'teste';
	var $uses = array();
	var $helpers = array(
		'Typographer.TypeDecorator' => array(
			'name' => 'typeDecorator',
			'compact' => false,
			'receive_tools' => true
		),
		'Typographer.*TypeStyleFactory' => array(
			'name' => 'styleFactory', 
			'receive_automatic_classes' => true, 
			'receive_tools' => true,
			'generate_automatic_classes' => false //significa que eu que vou produzir as classes automaticas
		),
		'Typographer.*TypeBricklayer' => array(
			'name' => 'bl',
			'receive_tools' => true
		)
	);
	
	function beforeRender()
	{	
		$this->TypeLayoutSchemePicker->pick($this->layout_scheme); //atenção que isto sobre-escreve a view escolhida
	}
	
	function teste()
	{
	}
}
?>
