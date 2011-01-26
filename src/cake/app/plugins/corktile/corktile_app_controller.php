<?php

class CorktileAppController extends AppController 
{
	var $components = array('Typographer.TypeLayoutSchemePicker');
	/*var $helpers = array(
		'Typographer.TypeDecorator' => array(
			'name' => 'Decorator',
			'compact' => false,
			'receive_tools' => true
		),
		'Typographer.*TypeStyleFactory' => array(
			'name' => 'StyleFactory',
			'receive_automatic_classes' => true,
			'receive_tools' => true,
			'generate_automatic_classes' => false //significa que eu que vou produzir as classes automaticas
		),
		'Typographer.*TypeBricklayer' => array(
			'name' => 'Bl',
			'receive_tools' => true,
		),
		'Burocrata.*BuroBurocrata' => array(
			'name' => 'Buro'
		),
		'Corktile.CorkCork'
	);*/


	var $layout = 'backstage';
	var $layout_scheme = 'backstage';

	function beforeRender()
	{
		Configure::write('Config.language','por');
	
		if(isset($this->layout_scheme))
		{
			$this->helpers = am(
				array(
					'Typographer.TypeDecorator' => array(
						'name' => 'Decorator',
						'compact' => false,
						'receive_tools' => true
					),
					'Typographer.*TypeStyleFactory' => array(
						'name' => 'styleFactory', 
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
				),
				$this->helpers
			);
			$this->TypeLayoutSchemePicker->pick($this->layout_scheme);
		}
		$this->set('user_name', 'Eleonora Cavalcante Albano');

	}

}

?>