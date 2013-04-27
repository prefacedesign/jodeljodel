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

/* Tests Test cases generated on: 2011-02-11 16:02:21 : 1297448481*/
App::import('Controller', 'PageSections.Tests');

class TestTestsController extends TestsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TestsControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->Tests =& new TestTestsController();
		$this->Tests->constructClasses();
	}

	function endTest() {
		unset($this->Tests);
		ClassRegistry::flush();
	}

}
?>