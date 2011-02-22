<?php

/**
 * Fixture class used in Translatable behavior test case.
 *
 * @copyright  Copyright 2010, Preface Design
 * @link       http://www.preface.com.br/
 * @license    MIT License <http://www.opensource.org/licenses/mit-license.php> - redistributions of files must retain the copyright notice
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 *
 * @author     Bruno Franciscon Mazzotti <mazzotti@preface.com.br>
 * @version    Jodel Jodel 0.1
 * @since      11. Nov. 2010
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

class ScenarioFixture extends CakeTestFixture
{
    var $name = 'Scenario';

    var $fields = array(
        'id' => array(
            'type' => 'integer',
            'key' => 'primary',
            'null' => false
        ),
        'play_id' => array(
            'type' => 'integer',
            'null' => false
        ),
		'number_of_objects' => array(
            'type' => 'integer',
            'null' => false
        )
    );
    
    var $records = array(
        // Antony and Cleopatra
        array(
            'id' => 1,
            'play_id' => 1,
            'number_of_objects' => 70,
		),
        // King Lear
        array(
            'id' => 2,
            'play_id' => 2,
            'number_of_objects' => 120
        ),
        // The Comedy of Errors
        array(
            'id' => 3,
            'play_id' => 3,
            'number_of_objects' => 1456
        ),
        // The Tragedy of Julius Caesar
        array(
            'id' => 4,
            'play_id' => 4,
            'number_of_objects' => 2
        ),
        // The Tragedy of Hamlet, Prince of Denmark
        array(
            'id' => 5,
            'play_id' => 5,
            'number_of_objects' => 200
        )
    );
}

?>
