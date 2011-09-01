<?php
/**
 * Plugin main behavior
 *
 * PHP versions 5
 * 
 * @package		jodel
 * @subpackage	jodel.content_stream.models
 */

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
	var $settings;
	
	function setup(&$Model, $options)
	{
		if (!isset($options['type']) || empty($options['type']) || !is_array($options['type']) || Set::numeric(array_keys($options['type'])))
		{
			trigger_error('CsContentStreamHolderBehavior::setup - The `type` parameter must be set on format: \'foreign_key\' => \'type\'');
			return false;
		}
		if (!$this->normalizeConfig())
			return false;
		
		$config = Configure::read('ContentStream');
		
		$Model->belongsTo['ContentStream'] = array(
			
		);
	}

/**
 * Creates all parameters on configuration using defaults, if not set.
 * 
 * @access public
 * @return boolean Return true if succefully nomalized, false, if not.
 */
	function normalizeConfig()
	{
		$config = Configure::read('ContentStream');
		if (Configure::read() && (!is_array($config['streams']) || Set::numeric(array_keys($config['streams']))))
		{
			trigger_error('CsContentStreamHolderBehavior::normalizeConfig - ContentStream.streams must be a array indexed by type of content stream.');
			return false;
		}
		
		$config['streams'] = Set::normalize($config['streams']);
		foreach ($config['streams'] as $type => &$stream)
		{
			if (!isset($stream['model'])) $stream['model'] = Inflector::camelize($type) . '.' . Inflector::classify($type);
			if (!isset($stream['controller'])) $stream['controller'] = Inflector::pluralize($type);
			if (!isset($stream['title'])) $stream['title'] = Inflector::humanize($type);
			
			$config['callbacks'] += array($type => array());
		}
		
		Configure::write('ContentStream', $config);
		return true;
	}
}