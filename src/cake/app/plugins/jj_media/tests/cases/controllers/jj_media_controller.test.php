<?php
/* JjMedias Test cases generated on: 2011-02-07 18:02:56 : 1297111796*/
App::import('Controller', 'JjMedia.JjMedia');

class TestJjMediaController extends JjMediaController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class JjMediaControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->JjMedia =& new TestJjMediaController();
		$this->JjMedia->constructClasses();
	}

	function endTest() {
		unset($this->JjMedia);
		ClassRegistry::flush();
	}

}
?>