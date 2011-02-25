<?php
/* AuthAuthor Test cases generated on: 2011-02-25 11:02:13 : 1298645293*/
App::import('Model', 'Author.AuthAuthor');

class AuthAuthorTestCase extends CakeTestCase {
	function startTest() {
		$this->AuthAuthor =& ClassRegistry::init('AuthAuthor');
	}

	function endTest() {
		unset($this->AuthAuthor);
		ClassRegistry::flush();
	}

}
?>