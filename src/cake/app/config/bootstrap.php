<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array(/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */
 
 /** Tells JodelJodel about wich modules are installed in the current installation.
  *  And provides some configuration of these modules.
  */
 Configure::write('jj.modules', array(
		'person' => array(
			'plugin' => 'person',
			'prefix' => 'pers',
			'model' => 'PersPerson',
			'humanName' => 'MODULE PersPerson human name', //it will be translated
			'plugged' => array('dashboard','backstage') //the tools and functionality it plugs into.
		),
		'new' => array(
			'plugin' => 'new',
			'prefix' => 'news',
			'model' => 'NewsNew',
			'humanName' => 'MODULE NewsNew human name',
			'plugged' => array('dashboard','backstage')
		),
		'paper' => array(
			'plugin' => 'paper',
			'prefix' => 'pap',
			'model' => 'PapPaper',
			'humanName' => 'MODULE PapPaper human name',
			'plugged' => array('dashboard','backstage')
		),
		'event' => array(
			'plugin' => 'event',
			'prefix' => 'eve',
			'model' => 'EveEvent',
			'humanName' => 'MODULE EveEvent human name',
			'plugged' => array('dashboard','backstage')
		),
		'text_cork' => array(
			'plugin' => 'text_cork',
			'prefix' => 'text',
			'model' => 'TextTextCork',
			'humanName' => 'MODULE TextTextCork human name',
			'plugged' => array('corktile')
		),
		'corktile' => array(
			'plugin' => 'corktile',
			'prefix' => 'cork',
			'model' => 'CorkCorktile',
			'humanName' => 'MODULE CorkCorkTile human name',
			'plugged' => array('dashboard', 'backstage')
		)
 ));
 
 

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

require APP . 'plugins' . DS . 'media' . DS . 'config' . DS . 'core.php';
require APP . 'plugins' . DS . 'typographer' . DS . 'config' . DS . 'core.php';

function br_strftime($formato, $tempo)
{
	$meses = array(
		1 => 'Janeiro',
		2 => 'Fevereiro',
		3 => 'Março',
		4 => 'Abril',
		5 => 'Maio',
		6 => 'Junho',
		7 => 'Julho',
		8 => 'Agosto',
		9 => 'Setembro',
		10 => 'Outubro',
		11 => 'Novembro',
		12 => 'Dezembro'
	);

	$data = getdate($tempo);
	return strftime(str_replace('%B',$meses[$data['mon']], $formato), $tempo);
}

