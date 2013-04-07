<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 * @author     Bruno Franciscon Mazzotti <mazzotti@preface.com.br>
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
