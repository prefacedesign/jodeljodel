<?php

class BackstageAppController extends AppController 
{
	var $components = array('Typographer.TypeLayoutSchemePicker', 'Tradutore.TradLanguageSelector');
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
			'generate_automatic_classes' => false //significa que eu que vou produzir as classes automaticas
		),
		'Typographer.*TypeBricklayer' => array(
			'name' => 'Bl',
			'receive_tools' => true,
		),
		'Burocrata.*BuroBurocrata' => array(
			'name' => 'Buro'
		),
		'Popup.Popup'
	);
	var $layout = 'backstage';
	
	
	
	function beforeRender()
	{
		parent::beforeRender();		
		$this->TypeLayoutSchemePicker->pick('backstage'); //atenчуo que isto sobre-escreve a view escolhida	
		$this->TradLanguageSelector->setInterfaceLanguage(Configure::read('Tradutore.mainLanguage'));
	}
	
	function beforeFilter()
	{
		parent::beforeFilter();
		StatusBehavior::setGlobalActiveStatuses(array('publishing_status' => array('active' => array('published','draft'), 'overwrite' => false)));
	}
	
	
}

?>