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