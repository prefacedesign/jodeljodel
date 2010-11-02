<?php

class EstilosController extends EstilistaAppController
{
	var $name = 'Estilos';
	var $layout = 'css';
	var $helpers = array(
		'Estilista.Pintor' => array(
			'nome' => 'Pintor',
			'compacto' => false,
			'modo' => 'inline_echo',
			'recebe_instrumentos' => true
		),
		'Estilista.*Fabriquinha' => array(
			'nome' => 'Fabriquinha', 
			'recebe_classes_automaticas' => false, 
			'recebe_instrumentos' => true,
			'produzir_classes_automaticas' => true //significa que eu que vou produzir as classes automaticas
		)
	);
	
	
	var $components = array('Estilista.SeletorDeModelos');
	var $uses = array();
	
	function estilo($modelo = 'padrao', $tipo = 'principal')
	{
		$this->SeletorDeModelos->escolheModeloDeLayout($modelo);
	}
	
	function beforeRender()
	{
		//faz nada - isto é para evitar o afterFilter do pai, que não tem nada a ver por aqui.
	}
}
?>
