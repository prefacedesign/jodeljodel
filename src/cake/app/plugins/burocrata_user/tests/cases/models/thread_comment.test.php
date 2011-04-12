<?php
/* ThreadComment Test cases generated on: 2011-04-12 12:04:29 : 1302621929*/
App::import('Model', 'burocrata_user.ThreadComment');

class ThreadCommentTestCase extends CakeTestCase {
	function startTest() {
		$this->ThreadComment =& ClassRegistry::init('ThreadComment');
	}

	function endTest() {
		unset($this->ThreadComment);
		ClassRegistry::flush();
	}

}
?>