<?php
/* AguaEquipes Test cases generated on: 2010-11-11 13:11:07 : 1289491147*/
App::import('Controller', 'agua_cascata.AguaEquipes');

class TestAguaEquipesController extends AguaEquipesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class AguaEquipesControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->AguaEquipes =& new TestAguaEquipesController();
		$this->AguaEquipes->constructClasses();
	}

	function endTest() {
		unset($this->AguaEquipes);
		ClassRegistry::flush();
	}

}
?>