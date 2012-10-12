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

class ScenarioTranslationFixture extends CakeTestFixture
{
    var $name = 'ScenarioTranslation';

    var $fields = array(
        'id' => array(
            'type' => 'integer',
            'key' => 'primary',
            'null' => false
        ),
        'scenario_id' => array(
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
        'concept' => array(
            'type' => 'string',
            'length' => 200,
            'default' => '',
            'null' => true
        )
    );
    
    var $records = array(
        // Antony and Cleopatra
        array(
            // English
            'id' => 1,
            'scenario_id' => 1,
            'language' => 'eng',
            'concept' => 'Classic',
        ),
        array(
            // German
            'id' => 2,
            'scenario_id' => 1,
            'language' => 'ger',
            'concept' => 'Klassik',
        ),
        array(
            // Ukrainian
            'id' => 3,
            'scenario_id' => 1,
            'language' => 'ukr',
            'concept' => 'Classic',
        ),
        array(
            // Latvian
            'id' => 4,
            'scenario_id' => 1,
            'language' => 'lav',
            'concept' => 'Klasisks',
        ),
        array(
            // Norwegian
            'id' => 5,
            'scenario_id' => 1,
            'language' => 'nno',
            'concept' => 'Klassiker',
        ),
        array(
            // Greek
            'id' => 6,
            'scenario_id' => 1,
            'language' => 'gre',
            'concept' => 'Κλασσικά',
        ),
        // King Lear
        array(
            // English
            'id' => 7,
            'scenario_id' => 2,
            'language' => 'eng',
            'concept' => 'Modern',
        ),
        array(
            // German
            'id' => 8,
            'scenario_id' => 2,
            'language' => 'ger',
            'concept' => 'Modernen',
        ),
        array(
            // Ukrainian
            'id' => 9,
            'scenario_id' => 2,
            'language' => 'ukr',
            'concept' => 'Сучасна',
        ),
        array(
            // Latvian
            'id' => 10,
            'scenario_id' => 2,
            'language' => 'lav',
            'concept' => 'Mūsdienu',
        ),
        array(
            // Norwegian
            'id' => 11,
            'scenario_id' => 2,
            'language' => 'nno',
            'concept' => 'Moderne',
        ),
        array(
            // Greek
            'id' => 12,
            'scenario_id' => 2,
            'language' => 'gre',
            'concept' => 'Σύγχρονες',
        ),
        // The Comedy of Errors
        array(
            // English
            'id' => 13,
            'scenario_id' => 3,
            'language' => 'eng',
            'concept' => 'Baroque',
        ),
        array(
            // German
            'id' => 14,
            'scenario_id' => 3,
            'language' => 'ger',
            'concept' => 'Barock',
        ),
        array(
            // Ukrainian
            'id' => 15,
            'scenario_id' => 3,
            'language' => 'ukr',
            'concept' => 'Бароко',
        ),
        array(
            // Latvian
            'id' => 16,
            'scenario_id' => 3,
            'language' => 'lav',
            'concept' => 'Baroka',
        ),
        array(
            // Norwegian
            'id' => 17,
            'scenario_id' => 3,
            'language' => 'nno',
            'concept' => 'Barokk',
        ),
        array(
            // Greek
            'id' => 18,
            'scenario_id' => 3,
            'language' => 'gre',
            'concept' => 'Μπαρόκ',
        ),
        // The Tragedy of Julius Caesar
        array(
            // English
            'id' => 19,
            'scenario_id' => 4,
            'language' => 'eng',
            'concept' => 'Postmodern',
        ),
        array(
            // German
            'id' => 20,
            'scenario_id' => 4,
            'language' => 'ger',
            'concept' => 'Postmodern',
        ),
        array(
            // Ukrainian
            'id' => 21,
            'scenario_id' => 4,
            'language' => 'ukr',
            'concept' => 'Постмодерн',
        ),
        array(
            // Latvian
            'id' => 22,
            'scenario_id' => 4,
            'language' => 'lav',
            'concept' => 'Postmodernu',
        ),
        array(
            // Norwegian
            'id' => 25,
            'scenario_id' => 4,
            'language' => 'nno',
            'concept' => 'Den postmoderne',
        ),
        array(
            // Greek
            'id' => 26,
            'scenario_id' => 4,
            'language' => 'gre',
            'concept' => 'Μεταμοντέρνο',
        ),
        // The Tragedy of Hamlet, Prince of Denmark
        array(
            // English
            'id' => 27,
            'scenario_id' => 5,
            'language' => 'eng',
            'concept' => 'Romantic',
        ),
        array(
            // German
            'id' => 28,
            'scenario_id' => 5,
            'language' => 'ger',
            'concept' => 'Romantische',
        ),
        array(
            // Ukrainian
            'id' => 29,
            'scenario_id' => 5,
            'language' => 'ukr',
            'concept' => 'Романтичний',
        ),
        array(
            // Latvian
            'id' => 30,
            'scenario_id' => 5,
            'language' => 'lav',
            'concept' => 'Romantisks',
        ),
        array(
            // Norwegian
            'id' => 31,
            'scenario_id' => 5,
            'language' => 'nno',
            'concept' => 'Romantisk',
        ),
        array(
            // Greek
            'id' => 32,
            'scenario_id' => 5,
            'language' => 'gre',
            'concept' => 'Ρομαντικός',
        )
    );
}

?>
