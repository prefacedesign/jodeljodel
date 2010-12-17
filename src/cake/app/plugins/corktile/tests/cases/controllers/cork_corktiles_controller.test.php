<?php
/* CorkCorktiles Test cases generated on: 2010-12-10 10:12:33 : 1291984053*/
App::import('Controller', 'corktile.CorkCorktiles');

class TestCorkCorktilesController extends CorkCorktilesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CorkCorktilesControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->CorkCorktiles =& new TestCorkCorktilesController();
		$this->CorkCorktiles->constructClasses();
	}

	function endTest() {
		unset($this->CorkCorktiles);
		ClassRegistry::flush();
	}

}
?>