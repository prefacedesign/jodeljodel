<?php
/* User Test cases generated on: 2010-11-30 15:11:36 : 1291144836*/
App::import('Model', 'BurocrataUser.User');

class UserTestCase extends CakeTestCase {
	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}

}
?>