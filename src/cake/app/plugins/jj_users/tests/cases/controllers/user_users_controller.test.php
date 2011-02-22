<?php
/* UserUsers Test cases generated on: 2011-02-14 21:02:11 : 1297726031*/
App::import('Controller', 'JjUsers.UserUsers');

class TestUserUsersController extends UserUsersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class UserUsersControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->UserUsers =& new TestUserUsersController();
		$this->UserUsers->constructClasses();
	}

	function endTest() {
		unset($this->UserUsers);
		ClassRegistry::flush();
	}

}
?>