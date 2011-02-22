<?php
/* SfilStoredFile Test cases generated on: 2011-02-07 17:02:35 : 1297108655*/
App::import('Model', 'JjMedia.SfilStoredFile');

class SfilStoredFileTestCase extends CakeTestCase {
	function startTest() {
		$this->SfilStoredFile =& ClassRegistry::init('SfilStoredFile');
	}

	function endTest() {
		unset($this->SfilStoredFile);
		ClassRegistry::flush();
	}

}
?>