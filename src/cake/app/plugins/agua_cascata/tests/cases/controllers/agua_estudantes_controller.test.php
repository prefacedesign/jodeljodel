<?php
/* AguaEstudantes Test cases generated on: 2010-11-11 14:11:04 : 1289491204*/
App::import('Controller', 'agua_cascata.AguaEstudantes');

class TestAguaEstudantesController extends AguaEstudantesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class AguaEstudantesControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->AguaEstudantes =& new TestAguaEstudantesController();
		$this->AguaEstudantes->constructClasses();
	}

	function endTest() {
		unset($this->AguaEstudantes);
		ClassRegistry::flush();
	}

}
?>