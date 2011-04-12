<?php
/* Comment Test cases generated on: 2011-04-12 12:04:39 : 1302621939*/
App::import('Model', 'burocrata_user.Comment');

class CommentTestCase extends CakeTestCase {
	function startTest() {
		$this->Comment =& ClassRegistry::init('Comment');
	}

	function endTest() {
		unset($this->Comment);
		ClassRegistry::flush();
	}

}
?>