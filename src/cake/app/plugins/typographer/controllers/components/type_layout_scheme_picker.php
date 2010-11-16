<?php
// @todo Maybe, there is no need of a component, maybe just adding an extra layer between
//    Controller and AppController can solve this issue.
App::import('Vendors', 'Estilista.tools');
App::import('Config', 'Estilista.config');

class TypeLayoutSchemePickerComponent extends Object 
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
		
	function pick($layout_scheme)
	{
		App::import('Config', 'Typographer.' . $layout_scheme . '_config');		
		$c_layout_scheme = Inflector::camelize($layout_scheme);
		
		//carrega os instrumentos e as configurações deste layout específico
		$tools = Configure::read('Typographer.' . $c_layout_scheme . '.tools');
		$used_automatic_classes = Configure::read('Typographer.' . $c_layout_scheme . '.used_automatic_classes');
	
		foreach($this->controller->helpers as $helper => $params)
		{
			if (is_array($params))
			{
				if (isset($params['receive_tools']))
				{
					$this->controller->helpers[$helper]['tools'] = $tools;
					unset($params['receive_tools']);
				}
				
				if (isset($params['receive_automatic_classes']))
				{
					$this->controller->helpers[$helper]['used_automatic_classes'] = $used_automatic_classes;
					unset($params['used_automatic_classes']);
				}
			}
		}
		
		if (isset($this->controller->view) && $this->controller->view != 'View')
		{
			debug($this->controller->view);
			trigger_error ('Atenção se quiser usar uma view diferente da View, é necessário implementar algo parecido com a EstilistaView');
		}
		$this->controller->view = 'Typographer.Type';
		$this->controller->set('used_automatic_classes', $used_automatic_classes);
		$this->controller->set($tools);
		$this->controller->set('layout_scheme', $layout_scheme);
	}
}
?>