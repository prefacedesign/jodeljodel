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
            'default' => 'eng',
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
            'language' => 'eng',
            'nacionality' => 'English'
        ),
		array(
            // Ukrainian
            'id' => 3,
            'author_id' => 1,
            'language' => 'ukr',
            'nacionality' => 'Англійська'
        ),
		// Italo Calvino
        array(
            // English
            'id' => 4,
            'author_id' => 2,
            'language' => 'eng',
            'nacionality' => 'Italian'
        ),
		array(
            // Ukrainian
            'id' => 6,
            'author_id' => 2,
            'language' => 'ukr',
            'nacionality' => 'Італійський'
        ),
		array(
            // German
            'id' => 7,
            'author_id' => 2,
            'language' => 'ger',
            'nacionality' => 'Italienisch'
        )
    );
}

?>
