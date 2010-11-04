<?php
/* AguaEscolas Test cases generated on: 2010-11-04 16:11:22 : 1288894342*/
App::import('Controller', 'agua_cascata.AguaEscolas');

class TestAguaEscolasController extends AguaEscolasController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class AguaEscolasControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->AguaEscolas =& new TestAguaEscolasController();
		$this->AguaEscolas->constructClasses();
	}

	function endTest() {
		unset($this->AguaEscolas);
		ClassRegistry::flush();
	}

}
?>