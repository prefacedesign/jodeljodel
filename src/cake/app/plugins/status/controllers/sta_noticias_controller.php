<?php
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