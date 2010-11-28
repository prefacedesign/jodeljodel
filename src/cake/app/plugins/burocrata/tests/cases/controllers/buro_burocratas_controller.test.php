<?php
/* BuroBurocratas Test cases generated on: 2010-11-20 23:11:37 : 1290301237*/
App::import('Controller', 'burocrata.BuroBurocratas');

class TestBuroBurocratasController extends BuroBurocratasController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class BuroBurocratasControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->BuroBurocratas =& new TestBuroBurocratasController();
		$this->BuroBurocratas->constructClasses();
	}

	function endTest() {
		unset($this->BuroBurocratas);
		ClassRegistry::flush();
	}

}
?>