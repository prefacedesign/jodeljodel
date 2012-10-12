<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

class StaNoticiasController extends StatusAppController 
{
	var $name = 'StaNoticias';
	var $uses = array('Status.StaNoticia','Status.StaProduto' );
	
	function index()
	{
		$this->StaNoticia->changeStatus(1, array('status' => 'rascunho'), false);
		debug($this->StaNoticia->find('all'));
		$this->StaProduto->changeStatus(1, array('disponibilidade' => 'inativo', 'etapa' => 'podre'), false);
		debug($this->StaNoticia->find('all'));
	}
}
?>