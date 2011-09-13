<?php
/**
 * Main behavior for this plugin
 *
 * PHP versions 5
 * 
 * @package		jodel
 * @subpackage	jodel.content_stream.models
 */

App::import('Lib', 'ContentStream.CsConfigurator');

/**
 * CsContentStreamHolderBehavior.
 *
 * A model that must be atached to models that will use a content stream input.
 * 
 * @package		jodel
 * @subpackage	jodel.content_stream.models
 */
class CsContentStreamHolderBehavior extends ModelBehavior
{
/**
 * Bahavior property that holds all settings. 
 * This property is populated on setup() and is accessed on BuroBurocrataHelper
 * 
 * @var array
 * @access public
 */
	var $settings;

/**
 * Invoke the normalization method and populates the $settings property.
 * 
 * @oaram model $Model
 * @param array $options
 * @access public
 */
	function setup(&$Model, $options)
	{
		if (!isset($options['streams']) || empty($options['streams']) || !is_array($options['streams']) || Set::numeric(array_keys($options['streams'])))
			return !trigger_error('CsContentStreamHolderBehavior::setup - The `streams` parameter must be set on format: \'foreign_key\' => \'type\'');
		
		$config = CsConfigurator::getConfig();
		
		$type = $have = $callbacks = $assocName = null;
		foreach ($options['streams'] as $fk => &$stream)
		{
			if (!is_array($stream)) 
				$stream = array('type' => $stream);
			
			if (isset($options['allowedContents']))
				$stream['allowedContents'] = $options['allowedContents'];
			elseif (isset($stream['type']) && is_string($stream['type']) && isset($config['types'][$stream['type']]))
				$stream['allowedContents'] = $config['types'][$stream['type']];
			else
				return !trigger_error('CsContentStreamHolderBehavior - It must be set `allowedContents`(array) or `type`(string). In case of `type` set, it must be configured on content_stream plugin.');
			
			foreach ($stream['allowedContents'] as $k=>$allowedContent)
			{
				if (!is_string($allowedContent))
					return !trigger_error('CsContentStreamHolderBehavior - Parameter allowed content must be an string.');
				elseif (!isset($config['streams'][$allowedContent]))
					return !trigger_error('CsContentStreamHolderBehavior - Content type `'.$allowedContent.'` not known.');
				
				$stream['allowedContents'][$allowedContent] = $config['streams'][$allowedContent];
				unset($stream['allowedContents'][$k]);
			}
			
			$stream['assocName'] = empty($stream['type']) ? Inflector::camelize($fk) : Inflector::camelize($stream['type']);
			$Model->belongsTo[$stream['assocName']] = array(
				'className' => 'ContentStream.CsContentStream',
				'foreignKey' => $fk,
			);
		}
		$this->settings[$Model->alias] = $options;
		$Model->__createLinks();
	}
}