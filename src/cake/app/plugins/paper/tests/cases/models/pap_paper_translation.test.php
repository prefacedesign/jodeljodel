<?php
/* PapPaperTranslation Test cases generated on: 2011-02-28 10:02:35 : 1298900135*/
App::import('Model', 'Paper.PapPaperTranslation');

class PapPaperTranslationTestCase extends CakeTestCase {
	function startTest() {
		$this->PapPaperTranslation =& ClassRegistry::init('PapPaperTranslation');
	}

	function endTest() {
		unset($this->PapPaperTranslation);
		ClassRegistry::flush();
	}

}
?>