<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

/* UserUser Test cases generated on: 2011-02-14 17:02:20 : 1297711880*/
App::import('Model', 'JjUsers.UserUser');

class UserUserTestCase extends CakeTestCase {
	function startTest() {
		$this->UserUser =& ClassRegistry::init('UserUser');
	}

	function endTest() {
		unset($this->UserUser);
		ClassRegistry::flush();
	}

}
?>