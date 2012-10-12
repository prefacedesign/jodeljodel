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
 * @author     Bruno Franciscon Mazzotti <mazzotti@preface.com.br>
 */

/**
 * Fixture class used in Translatable behavior test case.
 *
 * The fake data is about William Shakespeare's plays.
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 */

class PlayFixture extends CakeTestFixture
{

    var $name = 'Play';

    var $fields = array(
        'id' => array(
            'type' => 'integer',
            'key' => 'primary',
            'null' => false
        ),
		'author_id' => array(
            'type' => 'integer',
            'null' => false
        ),
        'year' => array(
            'type' => 'integer',
            'length' => 4,
            'null' => false
        )
    );
    
    var $records = array(
        array('id' => 1, 'author_id' => 1, 'year' => 1606),  // Antony and Cleopatra
        array('id' => 2, 'author_id' => 1, 'year' => 1605),  // King Lear
        array('id' => 3, 'author_id' => 1, 'year' => 1589),  // The Comedy of Errors
        array('id' => 4, 'author_id' => 2, 'year' => 1599),  // The Tragedy of Julius Caesar
        array('id' => 5, 'author_id' => 2, 'year' => 1600)   // The Tragedy of Hamlet, Prince of Denmark
    );
}

?>
