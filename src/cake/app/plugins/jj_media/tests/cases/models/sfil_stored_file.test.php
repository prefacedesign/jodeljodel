<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

/* SfilStoredFile Test cases generated on: 2011-02-07 17:02:35 : 1297108655*/
App::import('Model', 'JjMedia.SfilStoredFile');

class SfilStoredFileTestCase extends CakeTestCase {
	function startTest() {
		$this->SfilStoredFile =& ClassRegistry::init('SfilStoredFile');
	}

	function endTest() {
		unset($this->SfilStoredFile);
		ClassRegistry::flush();
	}

}
?>