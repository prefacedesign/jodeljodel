<?php
/* UserUser Test cases generated on: 2011-02-14 17:02:20 : 1297711880*/
App::import('Model', 'JjUsers.UserUser');

class UserUserTestCase extends CakeTestCase {
	function startTest() {
		$this->UserUser =& ClassRegistry::init('UserUser');
	}

	function endTest() {
		unset($this->UserUser);
		ClassRegistry::flush();
	}

}
?>