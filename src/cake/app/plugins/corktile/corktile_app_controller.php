<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

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
	
	function startupProcess()
	{
		$this->TradLanguageSelector->setInterfaceLanguage(Configure::read('Tradutore.mainLanguage'));
		parent::startupProcess();
	}
	
	function beforeRender()
	{
		parent::beforeRender();
		$this->TypeLayoutSchemePicker->pick('backstage');
	}
}

?>