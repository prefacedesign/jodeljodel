<?php
class UserUsersController extends JjUsersAppController {

	var $name = 'UserUsers';
	var $scaffold;
	
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