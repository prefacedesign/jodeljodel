<?php
/* ProgramItem Test cases generated on: 2010-11-11 11:11:21 : 1289483661*/
App::import('Model', 'BurocrataUser.ProgramItem');

class ProgramItemTestCase extends CakeTestCase {
	function startTest() {
		$this->ProgramItem =& ClassRegistry::init('ProgramItem');
	}

	function endTest() {
		unset($this->ProgramItem);
		ClassRegistry::flush();
	}

}
?>