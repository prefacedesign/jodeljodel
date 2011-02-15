<?php
/* UserGroup Test cases generated on: 2011-02-14 17:02:50 : 1297711970*/
App::import('Model', 'JjUsers.UserGroup');

class UserGroupTestCase extends CakeTestCase {
	function startTest() {
		$this->UserGroup =& ClassRegistry::init('UserGroup');
	}

	function endTest() {
		unset($this->UserGroup);
		ClassRegistry::flush();
	}

}
?>