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

class Author extends AppModel
{
    var $name = 'Author';
	var $actsAs = array('Cascata.AguaCascata', 'Tradutore.TradTradutore', 'Containable');
	var $hasOne = array('AuthorTranslation');
	var $hasMany = array('Image', 'Bioinfo');
	
}

?>
