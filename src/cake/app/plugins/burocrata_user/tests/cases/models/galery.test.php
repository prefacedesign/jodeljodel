<?php
/* Galery Test cases generated on: 2010-11-30 15:11:44 : 1291144724*/
App::import('Model', 'BurocrataUser.Galery');

class GaleryTestCase extends CakeTestCase {
	function startTest() {
		$this->Galery =& ClassRegistry::init('Galery');
	}

	function endTest() {
		unset($this->Galery);
		ClassRegistry::flush();
	}

}
?>