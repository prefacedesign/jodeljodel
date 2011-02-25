<?php
/* NewsNew Test cases generated on: 2011-02-25 11:02:44 : 1298643224*/
App::import('Model', 'New.NewsNew');

class NewsNewTestCase extends CakeTestCase {
	function startTest() {
		$this->NewsNew =& ClassRegistry::init('NewsNew');
	}

	function endTest() {
		unset($this->NewsNew);
		ClassRegistry::flush();
	}

}
?>