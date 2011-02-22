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

class AdvertisementFixture extends CakeTestFixture
{

    var $name = 'Advertisement';

    var $fields = array(
        'id' => array(
            'type' => 'integer',
            'key' => 'primary',
            'null' => false
        ),
		'play_id' => array(
            'type' => 'integer',
            'null' => false
        )
    );
    
    var $records = array(
        array('id' => 1, 'play_id' => 1),
        array('id' => 2, 'play_id' => 1),
		array('id' => 3, 'play_id' => 2),
		array('id' => 4, 'play_id' => 2),
		array('id' => 5, 'play_id' => 3),
		array('id' => 6, 'play_id' => 3),
		array('id' => 7, 'play_id' => 3),
		array('id' => 8, 'play_id' => 4),
    );
}

?>
