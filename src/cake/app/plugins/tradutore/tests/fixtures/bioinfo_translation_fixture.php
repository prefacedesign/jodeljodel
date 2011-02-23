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

class BioinfoTranslationFixture extends CakeTestFixture
{
    var $name = 'BioinfoTranslation';

    var $fields = array(
        'id' => array(
            'type' => 'integer',
            'key' => 'primary',
            'null' => false
        ),
		'bioinfo_id' => array(
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
		'type' => array(
            'type' => 'string',
            'length' => 80,
            'default' => '',
            'null' => false
        ),
		'info' => array(
            'type' => 'text',
            'null' => false
        ),
    );
    
    var $records = array(
        array(
            // English
            'id' => 1,
            'bioinfo_id' => 1,
            'language' => 'eng',
            'type' => 'secret',
            'info' => "Phil: Nay, but this dotage of our general's..."
        ),
        array(
            // German
            'id' => 2,
            'bioinfo_id' => 1,
            'language' => 'ger',
            'type' => 'segrein',
            'info' => "Phil: Nein, aber diese dotage unserer allgemeinen's..."
        ),
        array(
            // Ukrainian
            'id' => 3,
            'bioinfo_id' => 1,
            'language' => 'ukr',
            'type' => 'генераt',
            'info' => "Філ: Ні, але це дитинство нашого генерала..."
        ),
		array(
            // English
            'id' => 4,
            'bioinfo_id' => 2,
            'language' => 'eng',
            'type' => 'open',
            'info' => "Phil: Nay, but this dotage of our general's..."
        ),
        array(
            // German
            'id' => 5,
            'bioinfo_id' => 2,
            'language' => 'ger',
            'type' => 'upen',
            'info' => "Phil: Nein, aber diese dotage unserer allgemeinen's..."
        ),
        array(
            // Ukrainian
            'id' => 6,
            'bioinfo_id' => 2,
            'language' => 'ukr',
            'type' => 'ерot',
            'info' => "Філ: Ні, але це дитинство нашого генерала..."
        ),
		array(
            // English
            'id' => 7,
            'bioinfo_id' => 3,
            'language' => 'eng',
            'type' => 'open',
            'info' => "Phil: Nay, but this dotage of our general's..."
        ),
        array(
            // German
            'id' => 8,
            'bioinfo_id' => 3,
            'language' => 'ger',
            'type' => 'upen',
            'info' => "Phil: Nein, aber diese dotage unserer allgemeinen's..."
        ),
        array(
            // Ukrainian
            'id' => 9,
            'bioinfo_id' => 3,
            'language' => 'ukr',
            'type' => 'ерot',
            'info' => "Філ: Ні, але це дитинство нашого генерала..."
        ),
		array(
            // English
            'id' => 10,
            'bioinfo_id' => 4,
            'language' => 'eng',
            'type' => 'secret',
            'info' => "Phil: Nay, but this dotage of our general's..."
        ),
        array(
            // German
            'id' => 11,
            'bioinfo_id' => 4,
            'language' => 'ger',
            'type' => 'segrein',
            'info' => "Phil: Nein, aber diese dotage unserer allgemeinen's..."
        ),
        array(
            // Ukrainian
            'id' => 12,
            'bioinfo_id' => 4,
            'language' => 'ukr',
            'type' => 'генераt',
            'info' => "Філ: Ні, але це дитинство нашого генерала..."
        ),
		array(
            // English
            'id' => 13,
            'bioinfo_id' => 5,
            'language' => 'eng',
            'type' => 'secret',
            'info' => "Phil: Nay, but this dotage of our general's..."
        ),
        array(
            // German
            'id' => 14,
            'bioinfo_id' => 5,
            'language' => 'ger',
            'type' => 'segrein',
            'info' => "Phil: Nein, aber diese dotage unserer allgemeinen's..."
        ),
        array(
            // Ukrainian
            'id' => 15,
            'bioinfo_id' => 5,
            'language' => 'ukr',
            'type' => 'генераt',
            'info' => "Філ: Ні, але це дитинство нашого генерала..."
        ),
    );
}

?>
