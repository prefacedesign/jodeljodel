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


class TypeTesteController extends TypographerAppController
{
	var $name = 'Teste';
	var $layout = 'teste';
	var $layout_scheme = 'teste';
	var $uses = array();
	var $helpers = array(
		'Typographer.TypeDecorator' => array(
			'name' => 'decorator',
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
