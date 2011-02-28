<?php
/* PapPaper Test cases generated on: 2011-02-28 10:02:42 : 1298900022*/
App::import('Model', 'Paper.PapPaper');

class PapPaperTestCase extends CakeTestCase {
	function startTest() {
		$this->PapPaper =& ClassRegistry::init('PapPaper');
	}

	function endTest() {
		unset($this->PapPaper);
		ClassRegistry::flush();
	}

}
?>