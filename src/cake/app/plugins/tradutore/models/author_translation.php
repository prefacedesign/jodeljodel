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


/**
 * Mock object to test Translatable behavior.
 *
 * Conventions about translations models:
 * - ...
 * - ...
 * - ...
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 */

class AuthorTranslation extends AppModel
{
    var $name = 'AuthorTranslation';
	var $hasMany = array('Video');
}

?>
