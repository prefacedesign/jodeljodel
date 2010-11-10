<?php
/* Exemplos Test cases generated on: 2010-10-31 23:10:08 : 1288578428*/
App::import('Controller', 'buro_burocrata.Exemplos');

class TestExemplosController extends ExemplosController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ExemplosControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->Exemplos =& new TestExemplosController();
		$this->Exemplos->constructClasses();
	}

	function endTest() {
		unset($this->Exemplos);
		ClassRegistry::flush();
	}

}
?>