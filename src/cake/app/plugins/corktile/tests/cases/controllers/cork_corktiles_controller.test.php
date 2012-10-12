<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

/* CorkCorktiles Test cases generated on: 2010-12-10 10:12:33 : 1291984053*/
App::import('Controller', 'corktile.CorkCorktiles');

class TestCorkCorktilesController extends CorkCorktilesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CorkCorktilesControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->CorkCorktiles =& new TestCorkCorktilesController();
		$this->CorkCorktiles->constructClasses();
	}

	function endTest() {
		unset($this->CorkCorktiles);
		ClassRegistry::flush();
	}

}
?>