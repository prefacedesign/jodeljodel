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
 * Fixture class used in Translatable behavior test case.
 *
 * The fake data is about William Shakespeare's plays.
 *
 * The test database must br created with UFT-8 character encoding to allow the
 * strange characters. In MySQL execute:
 *   CREATE DATABASE database CHARACTER SET utf8 COLLATE utf8_bin
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 */

class PlaysTagFixture extends CakeTestFixture
{
    var $name = 'PlaysTag';

    var $fields = array(
        'play_id' => array(
            'type' => 'integer',
            'null' => false
        ),
        'tag_id' => array(
            'type' => 'integer',
            'null' => false
        )
    );
    
    var $records = array(
        array(
            'play_id' => 1,
            'tag_id' => 1
        ),
		array(
            'play_id' => 1,
            'tag_id' => 2
        ),
		array(
            'play_id' => 1,
            'tag_id' => 3
        ),
		array(
            'play_id' => 2,
            'tag_id' => 1
        ),
		array(
            'play_id' => 2,
            'tag_id' => 2
        ),
		array(
            'play_id' => 3,
            'tag_id' => 1
        ),
		array(
            'play_id' => 4,
            'tag_id' => 1
        ),
		array(
            'play_id' => 4,
            'tag_id' => 4
        ),
		array(
            'play_id' => 5,
            'tag_id' => 3
        ),
		array(
            'play_id' => 5,
            'tag_id' => 4
        ),
    );
}

?>
