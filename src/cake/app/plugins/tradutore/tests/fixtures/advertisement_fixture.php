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
