<?php

/**
 * Mock object class to test Translatable behavior.
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
 * Mock object to test Translatable behavior.
 *
 * The fake data is about William Shakespeare's plays.
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 */

class Play extends TradutoreAppModel
{
    var $name = 'Play';
	var $displayField = 'title';
	
	var $actsAs = array('Cascata.AguaCascata', 'Tradutore.TradTradutore', 'Containable');
	
	var $hasOne = array('PlayTranslation', 'Scenario');
	var $hasMany = array('Image', 'Advertisement');
	var $belongsTo = array('Author');
	var $hasAndBelongsToMany = array('Tag' => array('with' => 'PlaysTag'));

	
    // Equivalent to:
    // var $actsAs = array(
    //     'Tradutore.TradTradutore' => array(
    //         'className'       => 'PlayTranslation',
    //         'foreignKey'      => 'play_id',
    //         'languageField'   => 'language',
    //         'defaultLanguage' => 'en'
    //     )
    // );
	
}

?>
