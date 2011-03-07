<?php
class EveEventsController extends EventAppController {

	var $name = 'EveEvents';
	var $uses = array('Event.EveEvent');
	var $components = array('Typographer.TypeLayoutSchemePicker');
	
	var $helpers = array(
		'Typographer.TypeDecorator' => array(
			'name' => 'Decorator',
			'compact' => false,
			'receive_tools' => true
		),
		'Typographer.*TypeStyleFactory' => array(
			'name' => 'TypeStyleFactory',
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
		'Kulepona',
		'Corktile.Cork'
	);
	var $layout = 'dinafon';

	function beforeFilter()
	{
		parent::beforeFilter();
		StatusBehavior::setGlobalActiveStatuses(array(
			'publishing_status' => array('active' => array('published'), 'overwrite' => true),
		));
	}

	function beforeRender()
	{
		parent::beforeRender();
		$this->TypeLayoutSchemePicker->pick('dinafon');
	}
	
	function index()
	{
		$data = $this->EveEvent->find(
				'all',
				array(
					'contain' => array(),
					'order' => 'EveEvent.begins DESC'
				)
			);

		$this->set('data',$data);
	}
}
?>