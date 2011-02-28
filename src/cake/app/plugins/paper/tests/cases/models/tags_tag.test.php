<?php
/* TagsTag Test cases generated on: 2011-02-28 10:02:03 : 1298900163*/
App::import('Model', 'Paper.TagsTag');

class TagsTagTestCase extends CakeTestCase {
	function startTest() {
		$this->TagsTag =& ClassRegistry::init('TagsTag');
	}

	function endTest() {
		unset($this->TagsTag);
		ClassRegistry::flush();
	}

}
?>