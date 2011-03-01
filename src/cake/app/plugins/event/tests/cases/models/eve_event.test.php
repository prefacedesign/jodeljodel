<?php
/* EveEvent Test cases generated on: 2011-03-01 09:03:40 : 1298983900*/
App::import('Model', 'Event.EveEvent');

class EveEventTestCase extends CakeTestCase {
	function startTest() {
		$this->EveEvent =& ClassRegistry::init('EveEvent');
	}

	function endTest() {
		unset($this->EveEvent);
		ClassRegistry::flush();
	}

}
?>