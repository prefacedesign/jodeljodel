<?php
/* Picture Test cases generated on: 2010-11-30 15:11:27 : 1291144827*/
App::import('Model', 'BurocrataUser.Picture');

class PictureTestCase extends CakeTestCase {
	function startTest() {
		$this->Picture =& ClassRegistry::init('Picture');
	}

	function endTest() {
		unset($this->Picture);
		ClassRegistry::flush();
	}

}
?>