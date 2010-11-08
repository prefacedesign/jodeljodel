<?php
/* AguaProfessors Test cases generated on: 2010-11-04 11:11:23 : 1288878443*/
App::import('Controller', 'agua_cascata.AguaProfessors');

class TestAguaProfessorsController extends AguaProfessorsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class AguaProfessorsControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->AguaProfessors =& new TestAguaProfessorsController();
		$this->AguaProfessors->constructClasses();
	}

	function endTest() {
		unset($this->AguaProfessors);
		ClassRegistry::flush();
	}

}
?>