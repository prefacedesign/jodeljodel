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

/* UserGroup Test cases generated on: 2011-02-14 17:02:50 : 1297711970*/
App::import('Model', 'JjUsers.UserGroup');

class UserGroupTestCase extends CakeTestCase {
	function startTest() {
		$this->UserGroup =& ClassRegistry::init('UserGroup');
	}

	function endTest() {
		unset($this->UserGroup);
		ClassRegistry::flush();
	}

}
?>