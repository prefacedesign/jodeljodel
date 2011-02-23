<?php

/**
 * Mock object to test Translatable behavior.
 *
 *
 * Conventions about translations models:
 * - ...
 * - ...
 * - ...
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 */

class Advertisement extends AppModel
{
    var $name = 'Advertisement';
	var $actsAs = array('Cascata.AguaCascata', 'Tradutore.TradTradutore', 'Containable');
	var $hasOne = array('AdvertisementTranslation');
	var $belongsTo = array('Play');
}

?>
