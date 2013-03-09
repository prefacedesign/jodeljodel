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
			'model' => 'BurocrataUser.Person',
			'humanName' => __('MODULE Person human name', true),
			'plugged' => array('backstage','backstage_custom') //the tools and functionality it plugs into.
		),
		'gallery' => array(
			'model' => 'BurocrataUser.Galery',
			'viewUrl' => array('action' => 'example_of_view', 'controller' => 'example_of_controller'),  //the default action is "view", and the default controller is the {prefix} . '_' . pluralize({plugin})  -> used to the see on page in the dashboard
			'humanName' => __('MODULE Gallery human name', true),
			'plugged' => array('dashboard','backstage'),
			'additionalFilteringConditions' => array('Dashboard.additionalFilteringConditions'), // see plugins/dashboard/config/dash.php to more details (here, the component controlls if the user can edit one specific content)
			'permissions' => array(
				'delete' => array('backstage_delete_item', 'gallery'), 
				'edit_draft' => array('backstage_edit_draft', 'gallery'),
				'edit_published' => array('backstage_edit_published', 'gallery'),
				'create' => array('backstage_edit_draft', 'gallery'),
				'edit_publishing_status' => array('backstage_edit_publishing_status', 'gallery'),
				'view' => array('backstage_view_item', 'gallery'),
			),
		),
		'text_cork' => array(
			'model' => 'TextCork.TextTextCork',
			'humanName' => __('MODULE TextTextCork human name', true),
			'plugged' => array('corktile')
		),
		'pie_image' => array(
			'model' => 'PieImage.PieImage',
			'humanName' => __('MODULE PieImage human name', true),
			'plugged' => array('corktile')
		),
		'pie_file' => array(
			'model' => 'PieFile.PieFile',
			'humanName' => __('MODULE PieFile human name', true),
			'plugged' => array('corktile')
		),
		'pie_title' => array(
			'model' => 'PieTitle.PieTitle',
			'humanName' => __('MODULE PieTitle human name', true),
			'plugged' => array('corktile')
		),
		'cs_cork' => array(
			'model' => 'ContentStream.CsCork',
			'humanName' => __('MODULE CsCork human name', true),
			'plugged' => array('corktile')
		),
		'corktile' => array(
			'model' => 'CorkCorktile',
			'humanName' => __('MODULE CorkCorkTile human name', true),
			'plugged' => array('dashboard', 'backstage')
		),
		//admin user sections
		'user_users' => array(
			'model' => 'JjUsers.UserUser',
			'humanName' => __('MODULE UserUser human name', true),
			'plugged' => array('backstage', 'backstage_custom'),
			'permissions' => array(
				'delete' => array('user_delete'), 
				'edit' => array('user_edit'),
				'create' => array('user_add'),
				'view' => array('user_list'),
			),
		),
		'user_profiles' => array(
			'model' => 'JjUsers.UserProfile',
			'humanName' => __('MODULE UserProfile human name', true),
			'plugged' => array('backstage', 'backstage_custom')
		),
		'user_permissions' => array(
			'model' => 'JjUsers.UserPermission',
			'humanName' => __('MODULE UserPermission human name', true),
			'plugged' => array('backstage', 'backstage_custom')
		),
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
	//UGLY HACK to make it work with english too:
	
	if (Configure::read('Config.language') == 'por')
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
	else
		return strftime($formato, $tempo);
}

//DINAFON specific
//@todo Introduce something more sofisticated for time formatting
function _formatInterval($begin, $end)
{
	$beginArray = getdate($begin);
	$endArray = getdate($end);
	
	if ($beginArray['mon'] == $endArray['mon'])
	{
		return sprintf(
			__('%d-%d de %s de %d',true), 
			$beginArray['mday'],
			$endArray['mday'],
			br_strftime('%B', $begin),
			$endArray['year']
		);
	}
	else
	{
		return sprintf(
			__('%d de %s a %d de %s de %d',true), 
			$beginArray['mday'],
			br_strftime('%B', $begin),
			$endArray['mday'],
			br_strftime('%B', $end),
			$endArray['year']
		);
	}
}
