<?php
/* PersPeople Test cases generated on: 2011-02-25 17:02:19 : 1298666419*/
App::import('Controller', 'Person.PersPeople');

class TestPersPeopleController extends PersPeopleController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PersPeopleControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->PersPeople =& new TestPersPeopleController();
		$this->PersPeople->constructClasses();
	}

	function endTest() {
		unset($this->PersPeople);
		ClassRegistry::flush();
	}

}
?>