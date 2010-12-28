<?php

class DashboardAppController extends AppController 
{
	var $components = array('Typographer.TypeLayoutSchemePicker');
	var $helpers = array(
		'Typographer.TypeDecorator' => array(
			'name' => 'Decorator',
			'compact' => false,
			'receive_tools' => true
		),
		'Typographer.*TypeStyleFactory' => array(
			'name' => 'StyleFactory', 
			'receive_automatic_classes' => true, 
			'receive_tools' => true,
			'generate_automatic_classes' => false
		),
		'Typographer.*TypeBricklayer' => array(
			'name' => 'Bl',
			'receive_tools' => true,
		),
		'Burocrata.*BuroBurocrata' => array(
			'name' => 'Buro'
		)
	);
	var $layout = 'backstage';
	
	function beforeRender()
	{
		Configure::write('Config.language','por');
		$this->set('user_name', 'Eleonora Cavalcante Albano');
		$this->TypeLayoutSchemePicker->pick('backstage'); 
	}

}

?>