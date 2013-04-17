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
 * @author     Bruno Franciscon Mazzotti <mazzotti@preface.com.br>
 */

/**
 * Mock object to test Translatable behavior.
 *
 * The fake data is about William Shakespeare's plays.
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 */

class Image extends AppModel
{
    var $name = 'Image';

	var $belongsTo = array('Play', 'Author');
	
}

?>
