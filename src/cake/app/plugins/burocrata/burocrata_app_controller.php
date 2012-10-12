<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

/**
 * Plugin AppController
 *
 * The parent class for all controllers inside burocrata plugin.
 *
 * PHP versions 5
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.controllers
 */

/**
 * BurocrataAppController.
 *
 * Just a CakePHP convention.
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.controllers
 */
class BurocrataAppController extends AppController
{
	function startupProcess()
	{
		$this->TradLanguageSelector->setInterfaceLanguage(Configure::read('Tradutore.mainLanguage'));
		parent::startupProcess();
	}
}