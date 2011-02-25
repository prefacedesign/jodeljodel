<?php
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