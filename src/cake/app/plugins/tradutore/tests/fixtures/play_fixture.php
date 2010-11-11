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
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 */

class PlayFixture extends CakeTestFixture {

    var $name = 'Play';

    var $fields = array(
        'id' => array(
            'type' => 'integer',
            'key' => 'primary',
            'null' => false
        ),
        // Translatable.
        'title' => array(
            'type' => 'string',
            'length' => 80,
            'default' => '',
            'null' => false
        ),
        // Not translatable.
        'year' => array(
            'type' => 'integer',
            'length' => 4,
            'null' => false
        ),
        // Translatable.
        'opening_excerpt' => array(
            'type' => 'string',
            'length' => 200,
            'default' => '',
            'null' => true
        )
    );

    var $records = array(
        array(
            'id' => 1,
            'title' => 'Antony and Cleopatra',
            'year' => 1606,
            'opening_excerpt' => "Phil: Nay, but this dotage of our general's..."
        ),
        array(
            'id' => 2,
            'title' => 'King Lear',
            'year' => 1605,
            'opening_excerpt' => "Earl of Kent: I thought the King had more affected the Duke of Albany than Cornwall."
        ),
        array(
            'id' => 3,
            'title' => 'The Comedy of Errors',
            'year' => 1589,
            'opening_excerpt' =>
            "Aegeon: Proceed, Solinus, to procure my fall\nAnd by the doom of death end woes and all."
        ),
        array(
            'id' => 4,
            'title' => 'The Tragedy of Julius Caesar',
            'year' => 1599,
            'opening_excerpt' => "Flavius: Hence! home, you idle creatures get you home:\nIs this a holiday?"
        ),
        array(
            'id' => 5,
            'title' => 'The Tragedy of Hamlet, Prince of Denmark',
            'year' => 1600,
            'opening_excerpt' => "Bernardo: Who's there?"
        )
    );

}

?>
