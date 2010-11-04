<?php
class NoticiasController extends StastatusAppController 
{
	var $name = 'Noticias';
	var $uses = array('Stastatus.Noticia','Stastatus.Produto' );
	
	function index()
	{
		$this->Noticia->changeStatus(1, array('status' => 'rascunho'), false);
		debug($this->Noticia->find('all'));
		$this->Produto->changeStatus(1, array('disponibilidade' => 'inativo', 'etapa' => 'podre'), false);
		debug($this->Produto->find('all'));
	}
}
?>