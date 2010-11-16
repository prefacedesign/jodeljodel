<?php

class TypeStylesheetController extends TypographerAppController
{
	var $name = 'TypeStylesheet';
	var $layout = 'css';
	var $helpers = array(
		'Typographer.TypeDecorator' => array(
			'name' => 'decorator',
			'compact' => false,
			'mode' => 'inline_echo',
			'receive_tools' => true
		),
		'Typographer.*TypeStyleFactory' => array(
			'name' => 'styleFactory', 
			'receive_automatic_classes' => false, 
			'receive_tools' => true,
			'generate_automatic_classes' => true //significa que eu que vou produzir as classes automaticas
		)
	);
	
	
	var $components = array('Typographer.TypeLayoutSchemePicker');
	var $uses = array();
	
	function style($layout_scheme = 'standard', $type = 'main')
	{
		$this->TypeLayoutSchemePicker->pick($layout_scheme);
	}
	
	function beforeRender()
	{
		//faz nada - isto é para evitar o afterFilter do pai, que não tem nada a ver por aqui.
	}
}
?>
