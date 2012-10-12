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

class CategoriasController extends AppController 
{
	var $name = 'Categorias';
	var $uses = array('Tradutore.Categoria');
	var $components = array('Tradutore.TradLanguageSelector');
	
	function index()
	{
		//debug($this->Categoria->getLanguage());
		$data = array('Categoria' => array(
			'id' => 1,
			'cat' => 'guddens'
		));
		//$this->Categoria->setLanguage('ger');
		//$this->Categoria->save($data);
		$dados = $this->Categoria->find('all', array('language' => 'eng'));
		debug($dados);
		$dados = $this->Categoria->find('all');
		debug($dados);
		$dados = $this->Categoria->find('all', array('emptyTranslation' => true));
		debug($dados);
		//debug('teste');
		die;
	}
}
?>