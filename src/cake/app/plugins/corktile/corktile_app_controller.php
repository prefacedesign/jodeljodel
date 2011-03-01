<?php
class CorktileAppController extends AppController 
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
			'generate_automatic_classes' => false 
		),
		'Typographer.*TypeBricklayer' => array(
			'name' => 'Bl',
			'receive_tools' => true,
		),
		'Burocrata.*BuroBurocrata' => array(
			'name' => 'Buro'
		),
		'Popup.Popup',
		'Corktile.Cork', 
		'Text'
	);
	var $layout = 'backstage';	
	
	function beforeRender()
	{
		parent::beforeRender();
		$this->TypeLayoutSchemePicker->pick('backstage');
		$this->TradLanguageSelector->setInterfaceLanguage(Configure::read('Tradutore.mainLanguage'));
	}
}

?>