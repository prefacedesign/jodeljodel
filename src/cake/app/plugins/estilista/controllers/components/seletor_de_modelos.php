<?php
// @todo Maybe, there is no need of a component, maybe just adding an extra layer between
//    Controller and AppController can solve this issue.
App::import('Vendors', 'Estilista.instrumentos');
App::import('Config', 'Estilista.config');

class SeletorDeModelosComponent extends Object 
{
	function initialize(&$controller, $settings = array()) 
	{
		$this->controller =& $controller; //importante senão depois não temos acesso ao Controller
	}
	
	/* Por esta função se escolhe o modelo de layout que o controller quer
	   usar para renderizar uma certa view, e também a partir da variável
	   do controller $helpers_estilista, nós sabemos quais os helpers se
	   quer carregar e qual nome se quer dar para eles quando chegarem na view, 
	   o asterisco representa o nome do modelo. 
	  
	   $helpers_estilista = array('Estilista.Pintor' => 'pintor', 'Estilista.*Pedreiro' => 'h','Estilista.*Fabriquinha' => 'fabriquinha')
	   
	   $produzir_classes_automaticas = true; //se isto está setado e é true, as classes automáticas não serão registradas e serão
											 //passadas para a view como uma variável ambiental, se não estiver, as classes automáticas
											 //serão registradas (pela própria Fabriquinha no callback) como já utilizadas.
	*/
		
	function escolheModeloDeLayout($modelo)
	{
		App::import('Config', 'Estilista.' . $modelo . '_config');		
		$c_modelo = Inflector::camelize($modelo);
		
		//carrega os instrumentos e as configurações deste layout específico
		$instrumentos = Configure::read('Estilista.' . $c_modelo . '.instrumentos');
		$classes_automaticas_usadas = Configure::read('Estilista.' . $c_modelo . '.classes_automaticas_usadas');
	
	
		// carrega os helpers que precisamos
		/*
		$lista_de_helpers = $this->controller->helpers_estilista; // faço uma cópia para não zoar o foreach (uma vez que ele manipula o vetor)
		foreach ($lista_de_helpers as $helper => $parametros)
		{
			if (strpos($helper,'*') !== false)   //tem que ver se pode mexer assim no índice do foreach, acho que sim
			{
				$helper_real = str_replace('*', $c_modelo, $helper);
				$this->controller->helpers_estilista[$helper_real] = $parametros; //reformula o vetor colocando com os parametros
				unset($this->controller->helpers_estilista[$helper]);
				$helper = $helper_real;
			}
			
			$this->controller->helpers[$helper] = $parametros;
			
			$res = array_search($helper, $this->controller->helpers); // tira a string simples se ela existir
			if ($res != false)
			{
				unset($this->controller->helpers[$res]);
			}
		}*/
		
	
		foreach($this->controller->helpers as $helper => $parametros)
		{
			if (is_array($parametros))
			{
				if (isset($parametros['recebe_instrumentos']))
				{
					$this->controller->helpers[$helper]['instrumentos'] = $instrumentos;
					unset($parametros['recebe_instrumentos']);
				}
				
				if (isset($parametros['recebe_classes_automaticas']))
				{
					$this->controller->helpers[$helper]['classes_automaticas_usadas'] = $classes_automaticas_usadas;
					unset($parametros['recebe_classes_automaticas']);
				}
			}
		}
		
		if (isset($this->controller->view) && $this->controller->view != 'View')
		{
			trigger_error ('Atenção se quiser usar uma view diferente da View, é necessário implementar algo parecido com a EstilistaView');
		}
		$this->controller->view = 'Estilista.Estilista';
		$this->controller->set('classes_automaticas_usadas', $classes_automaticas_usadas);
		$this->controller->set($instrumentos);
		$this->controller->set('modelo_de_layout', $modelo);
	}
}
?>