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

/* PersPersonTranslation Test cases generated on: 2011-02-23 16:02:41 : 1298490581*/
App::import('Model', 'Person.PersPersonTranslation');

class PersPersonTranslationTestCase extends CakeTestCase {
	function startTest() {
		$this->PersPersonTranslation =& ClassRegistry::init('PersPersonTranslation');
	}

	function endTest() {
		unset($this->PersPersonTranslation);
		ClassRegistry::flush();
	}

}
?>