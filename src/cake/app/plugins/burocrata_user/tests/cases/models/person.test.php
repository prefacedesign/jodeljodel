<?php
/* Person Test cases generated on: 2011-04-12 12:04:06 : 1302620826*/
App::import('Model', 'burocrata_user.Person');

class PersonTestCase extends CakeTestCase {
	function startTest() {
		$this->Person =& ClassRegistry::init('Person');
	}

	function endTest() {
		unset($this->Person);
		ClassRegistry::flush();
	}

}
?>