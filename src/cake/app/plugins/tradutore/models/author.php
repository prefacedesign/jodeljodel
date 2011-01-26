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
	//var $actsAs = array('Cascata.AguaCascata', 'Tradutore.Translatable');
	var $actsAs = array('Tradutore.Translatable', 'Containable');
	var $hasOne = array('AuthorTranslation');
	//var $actsAs = array('Containable');
	//var $hasMany = array('Play');
	//var $displayField = 'id';
	
}

?>
