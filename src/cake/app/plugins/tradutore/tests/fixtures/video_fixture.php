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

class VideoFixture extends CakeTestFixture
{
    var $name = 'Video';

    var $fields = array(
        'id' => array(
            'type' => 'integer',
            'key' => 'primary',
            'null' => false
        ),
        'author_translation_id' => array(
            'type' => 'integer',
            'null' => true
        ),
		// Conforming ISO-639-1 language codes.
        'file' => array(
            'type' => 'string',
            'length' => 255,
            'null' => false
        )
    );
    
    var $records = array(
        array(
            'id' => 1,
            'author_translation_id' => 1,
            'file' => 'Shakespeare life.avi'
        ),
		array(
            'id' => 2,
			'author_translation_id' => 3,
            'file' => 'Шекспір життя.avi'
        ),
		array(
            'id' => 3,
			'author_translation_id' => 4,
            'file' => 'Italo Calvino life.avi'
        ),
		array(
            'id' => 4,
			'author_translation_id' => 6,
            'file' => 'Італо Кальвіно життя.avi'
        ),
    );
}

?>
