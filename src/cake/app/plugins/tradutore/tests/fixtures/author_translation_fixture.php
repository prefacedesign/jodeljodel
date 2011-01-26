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

class AuthorTranslationFixture extends CakeTestFixture
{
    var $name = 'AuthorTranslation';

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
		// Conforming ISO-639-1 language codes.
        'language' => array(
            'type' => 'string',
            'length' => 10,
            'default' => 'en',
            'null' => false
        ),
        'nacionality' => array(
            'type' => 'string',
            'length' => 80,
            'default' => '',
            'null' => false
        )
    );
    
    var $records = array(
        // Shakespeare
        array(
            // English
            'id' => 1,
            'author_id' => 1,
            'language' => 'en',
            'nacionality' => 'English'
        ),
		array(
            // Spanish
            'id' => 2,
            'author_id' => 1,
            'language' => 'es',
            'nacionality' => 'Ingles'
        ),
		array(
            // Portuguese
            'id' => 3,
            'author_id' => 1,
            'language' => 'pt',
            'nacionality' => 'Inglês'
        ),
		// Italo Calvino
        array(
            // English
            'id' => 4,
            'author_id' => 2,
            'language' => 'en',
            'nacionality' => 'Italian'
        ),
		array(
            // Spanish
            'id' => 5,
            'author_id' => 2,
            'language' => 'es',
            'nacionality' => 'Italiano'
        ),
		array(
            // Portuguese
            'id' => 6,
            'author_id' => 2,
            'language' => 'pt',
            'nacionality' => 'Italiano'
        )
    );
}

?>
