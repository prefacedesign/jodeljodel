<?php
/* BackContents Test cases generated on: 2010-11-27 17:11:26 : 1290885446*/
App::import('Controller', 'Backstage.BackContents');

class TestBackContentsController extends BackContentsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class BackContentsControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->BackContents =& new TestBackContentsController();
		$this->BackContents->constructClasses();
	}

	function endTest() {
		unset($this->BackContents);
		ClassRegistry::flush();
	}

}
?>