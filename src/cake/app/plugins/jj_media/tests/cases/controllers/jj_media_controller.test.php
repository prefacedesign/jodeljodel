<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

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