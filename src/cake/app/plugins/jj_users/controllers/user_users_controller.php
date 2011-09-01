<?php
class UserUsersController extends JjUsersAppController {

	var $name = 'UserUsers';
	var $scaffold;

	function beforeFilter()
	{
		$this->Auth->loginError = __d('backstage', 'Login failed. Invalid username or password.', true);
		$this->Auth->authError = __d('backstage', 'You are not authorized to access that location.', true);
		parent::beforeFilter();
	}
	
	function login()
	{
		$this->set('typeLayout','login');
	}
	
	function logout()
	{
		$this->redirect($this->Auth->logout());
	}
}
?>