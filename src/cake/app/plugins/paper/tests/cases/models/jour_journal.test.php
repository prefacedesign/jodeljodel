<?php
/* JourJournal Test cases generated on: 2011-02-28 10:02:43 : 1298900083*/
App::import('Model', 'Paper.JourJournal');

class JourJournalTestCase extends CakeTestCase {
	function startTest() {
		$this->JourJournal =& ClassRegistry::init('JourJournal');
	}

	function endTest() {
		unset($this->JourJournal);
		ClassRegistry::flush();
	}

}
?>