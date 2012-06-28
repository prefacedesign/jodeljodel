<?php

App::import('Component', 'Auth');
App::import('Lib', 'JjUsers.BigBadGuy');

class JjAuthComponent extends AuthComponent
{	
	protected $BigBadGuy;
	protected $_controller;

/**
 * Startup callback for initialize
 * 
 * @access public
 */
	function startup(&$controller)
	{
		$parent = parent::startup($controller);
		$this->_controller = $controller;
		$this->__loadClasses();
		return $parent;
	}

/**
 * Initializes used and variables
 * 
 * @access protected
 */
	protected function __loadClasses()
	{

		$permissions = $this->user('permissions');
		$id = $this->user('id');
		
		if (!empty($this->BigBadGuy) && !empty($permissions))
			return;

		if (empty($permissions) && !empty($id))
		{
			$userModel =& $this->getModel();
			$userData = $userModel->find('first', array('conditions' => array('UserUser.id' => $this->user('id')), 'contain' => array('UserProfile' => array('UserPermission'))));
			
			$permissions = array();

			foreach($userData['UserProfile'] as $profile)
			{
				foreach($profile['UserPermission'] as $permission)
				{
					$permissions[$permission['slug']] = 1;
				}
			}
			$userData['UserUser']['permissions'] = $permissions;
			unset($userData['UserProfile']);
			$this->Session->write('JjAuth.UserUser', $userData['UserUser']);
		}

		if (empty($id))
		{
			$this->Session->delete('JjAuth.UserUser');
		}
		
		$this->BigBadGuy = ClassRegistry::init('JjUsers.BigBadGuy');
	}


/**
 * Verify the permissions
 * 
 * @access public
 */
	public function can($what)
	{
		$this->__loadClasses();
		return $this->BigBadGuy->can($what, $this->user('permissions'));	
	}
	
/**
 * Stop the user and redirects to some place
 * 
 * @access public
 */
	public function stop($url = null)
	{
		$this->_controller->redirect($this->loginRedirect);
	}
}

