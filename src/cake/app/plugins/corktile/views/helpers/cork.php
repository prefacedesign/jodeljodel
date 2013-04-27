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
 */


class CorkHelper extends AppHelper 
{
/**
 * List of helpers
 * 
 * @var array
 * @access public
 */
	public $helpers = array('Html', 'Form', 'Ajax', 'Js' => 'prototype',
		'Typographer.*TypeBricklayer' => array(
			'name' => 'Bl'
		)
	);

/** 
 * This method inserts a Cork Tile in the spot, given the specified key.
 * 
 * If there's already content with this key, it will be used. Otherwise
 * a new one will be created. The Cork content will be enclosed by a special
 * div with the class 'cork'.
 * 
 * @see Model CorkCortile->getData
 *
 * @param array $htmlAttributes The htmlAttributes that will be used in the div
 *                              that contains the data.
 * @param array $options The settings of this special tile:
 *                        - 'key' -> string with the key of this tile (required).
 *                        - 'type' -> what type of cork we're using? (required).
 *                                    More data will be retrieved through the config
 *                                    key: 'jj.modules'.
 *                        - 'title' -> The title of the Cork - in few words what's
 *                                    the content about?
 *                        - 'editorsRecommendations' -> A free text recomending
 *                                    on how to fill the content. The administrators
 *                                    will see this code above the form.
 *                        - 'replaceOptions' -> Defaults to true. If set to false
 *                                     the options saved on DB will be used,
 *                                     otherwise if true, the options will be
 *                                     overwritten. If 'Corktile.overwrite' is set
 *                                     to true this will be assumed always true.
 *                        - 'defaultContent' -> An array with the default data
 *                                     that should be used, when it does not exist.
 *                        - 'options' -> These options will be passed on to the
 *                                     the content Model.
 * @todo Handle caching.
 * @todo Corktile shell: script that goes through all files resetting every
 *       piece of Cork.
 */
	function tile ($htmlAttributes = array(), $options = array())
	{
		$options += array(
			'key' => false,
			'type' => false,
			'options' => array()
		);
		
		if (empty($options['key']) || empty($options['type']))
		{
			trigger_error("CorkHelper::tile() - One must at least specify 'key' and 'type'"); 
			return null;
		}

		$View =& ClassRegistry::getObject('view');
		$use_cache = !isset($options['cache']) || $options['cache'] != false;
		if ($use_cache)
		{
			$cacheKey = "cork_{$options['key']}";
			if (isset($View->params['language']))
			{
				$cacheKey = "cork_{$options['key']}_{$View->params['language']}";
			}
			$cache = Cache::read($cacheKey);
			if ($cache)
				return $cache;
		}

		$htmlAttributes = $this->Bl->_mergeAttributes(array('class' => array('cork')), $htmlAttributes);

		if (!isset($options['location']))
			$options['location'] = $View->getVar('ourLocation');
		
		$CorkCorktile =& ClassRegistry::init('Corktile.CorkCorktile');
		$corkData = $CorkCorktile->getData($options); //This one handles all data logic.
		$options['options'] += $corkData[$CorkCorktile->alias]['options'];
		
		$typeConfig = Configure::read('jj.modules.' . $options['type']);
		if (!isset($typeConfig['model']))
		{
			trigger_error('CorkHelper::tile() - Error loading configuration for ' . $options['type']);
			return null;
		}
		
		list($plugin_name, $model_name) = pluginSplit($typeConfig['model']);
		
		$t = $this->Bl->sdiv($htmlAttributes);
		$t .=  $View->element(Inflector::underscore($model_name), array(
				'plugin' => Inflector::underscore($plugin_name),
				'type' => array('cork'),
				'options' => isset($options['options']) ? $options['options'] : array(),
				'data' => $corkData
			)
		);
		$t .= $this->Bl->ediv();

		if ($use_cache)
		{
			Cache::write($cacheKey, $t);
		}
		return $t;
	}
}
