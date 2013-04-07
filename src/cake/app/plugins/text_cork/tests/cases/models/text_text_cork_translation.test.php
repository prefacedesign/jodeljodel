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

/* TextTextCorkTranslation Test cases generated on: 2011-02-27 21:02:40 : 1298854720*/
App::import('Model', 'TextCork.TextTextCorkTranslation');

class TextTextCorkTranslationTestCase extends CakeTestCase {
	function startTest() {
		$this->TextTextCorkTranslation =& ClassRegistry::init('TextTextCorkTranslation');
	}

	function endTest() {
		unset($this->TextTextCorkTranslation);
		ClassRegistry::flush();
	}

}
?>