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

class TagTranslationFixture extends CakeTestFixture
{
    var $name = 'TagTranslation';

    var $fields = array(
        'id' => array(
            'type' => 'integer',
            'key' => 'primary',
            'null' => false
        ),
        'tag_id' => array(
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
        'tag' => array(
            'type' => 'string',
            'length' => 80,
            'default' => '',
            'null' => false
        )
    );
    
    var $records = array(
        array(
            // English
            'id' => 1,
            'tag_id' => 1,
            'language' => 'eng',
            'tag' => 'cool'
        ),
		array(
            // Ukrainian
            'id' => 2,
            'tag_id' => 1,
            'language' => 'ukr',
            'tag' => 'прохолодно'
        ),
        array(
            // English
            'id' => 3,
            'tag_id' => 2,
            'language' => 'eng',
            'tag' => 'beautiful'
        ),
		array(
            // Ukrainian
            'id' => 4,
            'tag_id' => 2,
            'language' => 'ukr',
            'tag' => 'красивий'
        ),
		array(
            // German
            'id' => 5,
            'tag_id' => 2,
            'language' => 'ger',
            'tag' => 'schön'
        ),
		array(
            // English
            'id' => 6,
            'tag_id' => 3,
            'language' => 'eng',
            'tag' => 'horrendous'
        ),
		array(
            // Ukrainian
            'id' => 7,
            'tag_id' => 3,
            'language' => 'ukr',
            'tag' => 'жахливий'
        ),
		array(
            // German
            'id' => 8,
            'tag_id' => 3,
            'language' => 'ger',
            'tag' => 'entsetzlich'
        ),
		array(
            // English
            'id' => 9,
            'tag_id' => 4,
            'language' => 'eng',
            'tag' => 'fabulous'
        ),
		array(
            // Ukrainian
            'id' => 10,
            'tag_id' => 4,
            'language' => 'ukr',
            'tag' => 'нечуваний'
        ),
		array(
            // German
            'id' => 11,
            'tag_id' => 4,
            'language' => 'ger',
            'tag' => 'fabelhaft'
        )
    );
}

?>
