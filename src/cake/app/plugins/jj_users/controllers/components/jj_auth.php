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


App::import('Component', 'Auth');
App::import('Lib', 'JjUsers.BigBadGuy');

class JjAuthComponent extends AuthComponent
{

/**
 * Holds a reference to the current controller object
 * 
 * @var object
 * @access protected
 */
	protected $Controller;

/**
 * Initialize callback for initialize
 * 
 * @access public
 */
	function initialize(&$Controller, $settings = array())
	{
		$settings += array(
			'userModel' => 'JjUsers.UserUser',
			'sessionKey' => 'JjAuth.UserUser',
			'loginError' => __d('backstage', 'Login failed. Invalid username or password.', true),
			'authError' => __d('backstage', 'You are not authorized to access that location.', true),
			'loginAction' => array(
				'plugin' => 'jj_users', 'controller' => 'user_users', 'action' => 'login'
			),
			'loginRedirect' => array(
				'plugin' => 'dashboard', 'controller' => 'dash_dashboard', 'action' => 'index'
			)
		);

		parent::initialize($Controller, $settings);
		
		$this->Controller = $Controller;
		$this->compilePermissions();
	}

/**
 * Compile the array of permissions suming all UserPermission.slug from database.
 * 
 * For performance pouposes, this array is cached on a session var. But it checks
 * for the `modified` field on users table to decide when is necessary to update
 * the cache.
 * 
 * @access protected
 * @param boolean $force When true, the cache will be updated
 * @return void
 */
	protected function compilePermissions($force = false)
	{
		$id = $this->user('id');
		if (empty($id))
		{
			$this->Session->delete($this->sessionKey);
			return;
		}

		$userModel =& $this->getModel();
		$permissions = $this->user('permissions');

		if (!empty($permissions))
		{
			$userModel->id = $id;
			$last_modified_at = $userModel->field('modified');
			$force = $force || $last_modified_at != $this->user('modified');

			if (!$force)
			{
				return;
			}
		}

		$userData = $userModel->find('first', array(
			'conditions' => array('UserUser.id' => $this->user('id')),
			'contain' => array('UserProfile' => array('UserPermission'))
		));

		$slugs = Set::extract('/UserPermission/slug', $userData['UserProfile']);
		unset($userData['UserProfile']);

		$userData['UserUser']['permissions'] = array_fill_keys($slugs, 1);
		$this->Session->write($this->sessionKey, $userData['UserUser']);
	}

/**
 * Verify the permissions
 * 
 * @access public
 */
	public function can($what)
	{
		$this->compilePermissions();
		return BigBadGuy::can($what, $this->user('permissions'));	
	}
	
/**
 * Stop the user and redirects to some place
 * 
 * @access public
 */
	public function stop()
	{
		$this->Controller->redirect($this->loginRedirect);
	}
}

