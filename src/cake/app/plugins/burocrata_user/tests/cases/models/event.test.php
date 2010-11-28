<?php
/* Event Test cases generated on: 2010-11-11 11:11:54 : 1289483634*/
App::import('Model', 'BurocrataUser.Event');

class EventTestCase extends CakeTestCase {
	function startTest() {
		$this->Event =& ClassRegistry::init('Event');
	}

	function endTest() {
		unset($this->Event);
		ClassRegistry::flush();
	}

}
?>