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

class TagFixture extends CakeTestFixture
{
    var $name = 'Tag';

    var $fields = array(
        'id' => array(
            'type' => 'integer',
            'key' => 'primary',
            'null' => false
        )
    );
    
    var $records = array(
        array(
            'id' => 1
        ),
		array(
            'id' => 2
        ),
		array(
            'id' => 3
        ),
		array(
            'id' => 4
        )
    );
}

?>
