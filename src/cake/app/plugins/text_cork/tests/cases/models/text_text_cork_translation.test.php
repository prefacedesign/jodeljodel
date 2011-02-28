<?php
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