<?php
/* EveEvents Test cases generated on: 2011-03-06 17:03:17 : 1299445157*/
App::import('Controller', 'Event.EveEvents');

class TestEveEventsController extends EveEventsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class EveEventsControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->EveEvents =& new TestEveEventsController();
		$this->EveEvents->constructClasses();
	}

	function endTest() {
		unset($this->EveEvents);
		ClassRegistry::flush();
	}

}
?>