<?php

class TesteController extends EstilistaAppController
{
	var $name = 'Teste';
	var $layout = 'teste';
	var $modelo = 'teste';
	var $uses = array();
	var $helpers = array(
		'Estilista.Pintor' => array(
			'nome' => 'Pintor',
			'compacto' => false,
			'recebe_instrumentos' => true
		),
		'Estilista.*Fabriquinha' => array(
			'nome' => 'Fabriquinha', 
			'recebe_classes_automaticas' => true, 
			'recebe_instrumentos' => true,
			'produzir_classes_automaticas' => false //significa que eu que vou produzir as classes automaticas
		),
		'Estilista.*Pedreiro' => array(
			'nome' => 'H',
			'recebe_instrumentos' => true
		)
	);
	
	function beforeRender()
	{	
		$this->SeletorDeModelos->escolheModeloDeLayout($this->modelo); //atenção que isto sobre-escreve a view escolhida
	}
	
	function teste()
	{
	}
}
?>
