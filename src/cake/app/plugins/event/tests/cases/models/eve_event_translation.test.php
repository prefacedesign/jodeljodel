<?php
/* EveEventTranslation Test cases generated on: 2011-03-01 09:03:22 : 1298984062*/
App::import('Model', 'Event.EveEventTranslation');

class EveEventTranslationTestCase extends CakeTestCase {
	function startTest() {
		$this->EveEventTranslation =& ClassRegistry::init('EveEventTranslation');
	}

	function endTest() {
		unset($this->EveEventTranslation);
		ClassRegistry::flush();
	}

}
?>