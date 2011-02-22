<?php

/**
 * Mock object to test Translatable behavior.
 *
 * The fake data is about William Shakespeare's plays.
 *
 * Conventions about translations models:
 * - ...
 * - ...
 * - ...
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 */

class PlaysTag extends AppModel 
{
    var $name = 'PlaysTag';
    var $belongsTo = array('Play', 'Tag');
	var $actsAs = array('Cascata.AguaCascata', 'Containable');
}


?>
