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
	
/**
 * Overwrtiging the startupProcess method so we can set (forced) 
 * the language before the pageSections load.
 * 
 * @access public
 */
	function startupProcess()
	{
		$this->TradLanguageSelector->setInterfaceLanguage(Configure::read('Tradutore.mainLanguage'));
		parent::startupProcess();
	}
	
	function beforeRender()
	{
		parent::beforeRender();		
		$this->TypeLayoutSchemePicker->pick('backstage'); //atenção que isto sobre-escreve a view escolhida	
	}
	
	function beforeFilter()
	{
		parent::beforeFilter();
		StatusBehavior::setGlobalActiveStatuses(array('publishing_status' => array('active' => array('published','draft'), 'overwrite' => false)));
	}
	
	
}

?>
