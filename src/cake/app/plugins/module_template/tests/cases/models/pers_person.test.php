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

/* PersPerson Test cases generated on: 2010-12-03 09:12:11 : 1291375571*/
App::import('Model', 'Person.PersPerson');

class PersPersonTestCase extends CakeTestCase {
	function startTest() {
		$this->PersPerson =& ClassRegistry::init('PersPerson');
	}

	function endTest() {
		unset($this->PersPerson);
		ClassRegistry::flush();
	}

}
?>