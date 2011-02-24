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
		$this->set('user_name', 'Eleonora Cavalcante Albano');
		$this->TypeLayoutSchemePicker->pick('backstage'); //atenчуo que isto sobre-escreve a view escolhida	
		$this->TradLanguageSelector->setInterfaceLanguage(Configure::read('Tradutore.mainLanguage'));
		//debug(Configure::read('Config.language'));
		//debug(TradLanguageSelector);
	}
	
	
}

?>