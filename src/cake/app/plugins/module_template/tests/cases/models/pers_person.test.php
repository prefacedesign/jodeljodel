<?php
/* PersPerson Test cases generated on: 2010-12-03 09:12:11 : 1291375571*/
App::import('Model', 'Person.PersPerson');

class PersPersonTestCase extends CakeTestCase {
	function startTest() {
		$this->PersPerson =& ClassRegistry::init('PersPerson');
	}

	function endTest() {
		unset($this->PersPerson);
		ClassRegistry::flush();
	}

}
?>