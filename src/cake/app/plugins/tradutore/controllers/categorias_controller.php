<?php
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