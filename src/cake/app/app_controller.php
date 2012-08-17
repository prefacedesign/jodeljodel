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
	var $helpers = array('Html', 'Form', 'Session', 'Time', 'Ajax', 'JjUsers.JjAuth');
	var $components = array(
		'Tradutore.TradLanguageSelector',
		'PageSections.SectSectionHandler',
		'JjUsers.JjAuth' => array(
			'userModel' => 'JjUsers.UserUser',
			'sessionKey' => 'JjAuth.UserUser',
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
		$user = $this->JjAuth->user();
		list($userPlugin, $userModel) = pluginSplit($this->JjAuth->userModel);
		$user = $user[$userModel];
		
		App::Import('Behavior', 'Status.Status');
		
		//starts all status with nothing active
		StatusBehavior::setGlobalActiveStatuses(array(
			'publishing_status' => array('active' => array(), 'overwrite' => true, 'mergeWithCurrentActiveStatuses' => false),
		));
		
		// in the applicationAppController or in each controller of a plugin (in beforeRender) is need to add the status, like this
		/*
			StatusBehavior::setGlobalActiveStatuses(array(
				'publishing_status' => array('active' => array('published'), 'overwrite' => true, 'mergeWithCurrentActiveStatuses' => false),
			));
		*/
		
		$curModule = array();
		if ($this->params['plugin'])
		{
			$curModule = Configure::read('jj.modules.'.$this->params['plugin']);
			if (empty($curModule))
			{
				$module = split('_', $this->params['plugin']);
				if (isset($module[1]))
					$curModule = Configure::read('jj.modules.'.$module[1]);
				if (empty($curModule))
				{
					if (isset($module[1]))
						$curModule = Configure::read('jj.modules.'.Inflector::singularize($module[1]));
				}
			}
		}
		if (!empty($curModule))
		{
			list($plugin, $model) = pluginSplit($curModule['model']);
			if (!isset($curModule['viewUrl']))
				$curModule['viewUrl'] = array();
			if (!is_array($curModule['viewUrl']))
			{
				trigger_error('BackstageTypeBricklayerHelper::moduleView() - `viewUrl` configuration must be an array.');
				return false;
			}
			
			$plugin = Inflector::underscore($plugin);
			
			$standardUrl = $curModule['viewUrl'] + array(
				'plugin' => $plugin, 
				'controller' => Inflector::pluralize($plugin),
				'action' => 'view'
			);
		}
		else
		{
			$standardUrl = array(
				'controller' => 'controller',
				'action' => 'view'
			);
		}
		
		if ($this->params['action'] == $standardUrl['action'] && $this->params['controller'] == $standardUrl['controller'])
		{
			if ($this->JjAuth->can('view_drafts'))
			{
				//if the user have the permission view_drafts then the status are changed to published and draft
				StatusBehavior::setGlobalActiveStatuses(array(
					'publishing_status' => array('active' => array('published', 'draft'), 'overwrite' => true, 'mergeWithCurrentActiveStatuses' => true),
				));
				
			}
		}
	}
	
	
	function beforeRender()
	{
		parent::beforeRender();		
		$userData = $this->JjAuth->user();
		$this->set('userData',$userData['UserUser']);
	}
	
	function isAuthorized()
	{
		return false;
	}
	
	protected function jodelError($message)
	{
		if (Configure::read() == 0)
			$this->cakeError('error500');
		
		$this->header("HTTP/1.0 500 Internal Server Error");
		$this->cakeError('error', array('code' => 500, 'name' => __('Jodel Jodel internal error', true), 'message' => $message));
	}
}
