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

class ImageFixture extends CakeTestFixture
{
    var $name = 'Image';

    var $fields = array(
        'id' => array(
            'type' => 'integer',
            'key' => 'primary',
            'null' => false
        ),
        'play_id' => array(
            'type' => 'integer',
            'null' => true
        ),
		'author_id' => array(
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
            'play_id' => 1,
			'author_id' => null,
            'file' => 'teste.bmp'
        ),
		array(
            'id' => 2,
            'play_id' => 1,
			'author_id' => null,
            'file' => 'oficial.bmp'
        ),
		array(
            'id' => 3,
            'play_id' => 2,
			'author_id' => null,
            'file' => 'muito_legal.bmp'
        ),
		array(
            'id' => 4,
            'play_id' => 2,
			'author_id' => null,
            'file' => 'show.bmp'
        ),
		array(
            'id' => 5,
            'play_id' => 3,
			'author_id' => null,
            'file' => 'magica.bmp'
        ),
		array(
            'id' => 6,
            'play_id' => 3,
			'author_id' => null,
            'file' => 'caraca.bmp'
        ),
		array(
            'id' => 7,
            'play_id' => 3,
			'author_id' => null,
            'file' => 'brilhante.bmp'
        ),
		array(
            'id' => 8,
            'play_id' => 4,
			'author_id' => null,
            'file' => 'fico bonito.bmp'
        ),
		array(
            'id' => 9,
            'play_id' => 4,
			'author_id' => null,
            'file' => 'vai ficar bom.bmp'
        ),
		array(
            'id' => 10,
            'play_id' => 4,
			'author_id' => null,
            'file' => 'ja ficou bom.bmp'
        ),
		array(
            'id' => 11,
			'play_id' => null,
            'author_id' => 1,
            'file' => 'Shakespeare.bmp'
        ),
    );
}

?>
