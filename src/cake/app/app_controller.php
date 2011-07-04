<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
	var $helpers = array('Html', 'Form', 'Javascript', 'Session', 'Time');
	var $components = array(
		'Acl',
		'Tradutore.TradLanguageSelector',
		'PageSections.SectSectionHandler',
		'Auth' => array(
			'userModel' => 'JjUsers.UserUser',
			'authorize' => 'controller',
			'loginRedirect' => array(
				'plugin' => 'dashboard',
				'controller' => 'dash_dashboard',
				'action' => 'index',
			)
		),
	);
	
	
	function beforeFilter()
	{
		parent::beforeFilter();		
		$this->set('jjModules', Configure::read('jj.modules'));
	}
	
	function beforeRender()
	{
		parent::beforeRender();		
		$userData = $this->Auth->user();
		$this->set('userData',$userData['UserUser']);
	}
	
	function isAuthorized()
	{
		if (!empty($this->SectSectionHandler->thisSection['acos']))
		{
			$user = $this->Auth->user();
			list($userPlugin, $userModel) = pluginSplit($this->Auth->userModel);
			$user = $user[$userModel];
			
			foreach ($this->SectSectionHandler->thisSection['acos'] as $aco => $actions)
			{
				if (is_numeric($aco)) //array('aco') -- defaults to array('aco' => 'read')
				{
					$aco = $actions;
					$actions = array('*');
				}
				
				foreach($actions as $action)
				{
					if (!$this->Acl->check($user['username'], $aco, $action))
						return false;
				}
			}
		}
		return true;
	}
	
}
