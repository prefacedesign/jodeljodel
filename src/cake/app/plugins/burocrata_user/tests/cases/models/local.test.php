<?php
/* Local Test cases generated on: 2010-11-11 11:11:05 : 1289483645*/
App::import('Model', 'BurocrataUser.Local');

class LocalTestCase extends CakeTestCase {
	function startTest() {
		$this->Local =& ClassRegistry::init('Local');
	}

	function endTest() {
		unset($this->Local);
		ClassRegistry::flush();
	}

}
?>