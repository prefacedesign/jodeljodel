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