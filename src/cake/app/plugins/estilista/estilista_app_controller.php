<?php
	// @todo write documentation for the layout framework and dive it a definitive name.

	class EstilistaAppController extends AppController
	{
		var $components = array('Estilista.SeletorDeModelos');
		var $modelo = 'teste'; // @todo change the default test layout scheme
		var $config_helpers;
		var $layout = 'estilista.teste';
		
		function beforeRender()
		{
			$this->helpers = am($this->helpers, array(
				'Estilista.Pintor' => array(
					'nome' => 'Pintor',
					'compacto' => false,
					'modo' => 'cabecalho_layout',
					'qual_css_armazenar' => 'estilo_instantaneo.css',
					'recebe_instrumentos' => true
				),
				'Estilista.*Fabriquinha' => array( //ATENÇÃO!!!! ---- Fabriquinha sempre deve vir antes, uma vez que a usamos com estes parametros dentro do Pedreiro
					'nome' => 'Fabriquinha', 
					'recebe_classes_automaticas' => true, 
					'recebe_instrumentos' => true,
					'registra_classes_automaticas' => true,
					'produzir_classes_automaticas' => false //significa que eu que NÃO vou produzir as classes automaticas
				),
				'Estilista.*Pedreiro' => array(
					'nome' => 'H',
					'recebe_instrumentos' => true
				)				
			);
			
			$this->SeletorDeModelos->escolheModeloDeLayout($this->modelo); //atenção que isto sobre-escreve a view escolhida
		);
		}
	}

?>