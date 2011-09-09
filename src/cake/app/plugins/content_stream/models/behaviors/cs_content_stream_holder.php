<?php
/**
 * Main behavior for this plugin
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
		if (!isset($options['streams']) || empty($options['streams']) || !is_array($options['streams']) || Set::numeric(array_keys($options['streams'])))
			return !trigger_error('CsContentStreamHolderBehavior::setup - The `streams` parameter must be set on format: \'foreign_key\' => \'type\'');
		
		if (!$this->normalizeConfig())
			return false;
		
		$config = Configure::read('ContentStream');
		
		$type = $have = $callbacks = $assocName = null;
		foreach ($options['streams'] as $fk => &$stream)
		{
			if (!is_array($stream)) 
				$stream = array('type' => $stream);
			$stream['assocName'] = empty($stream['type']) ? Inflector::camelize($fk) : Inflector::camelize($stream['type']);
			
			if (isset($options['allowedContents']))
				$stream['allowedContents'] = $options['allowedContents'];
			elseif (isset($stream['type']) && isset($config['types'][$stream['type']]))
				$stream['allowedContents'] = $config['types'][$stream['type']];
			else
				return !trigger_error('CsContentStreamHolderBehavior - It must be set `allowedContents` or `type`. In case of `type` set, it must be configured on content_stream plugin.');
			
			$Model->belongsTo[$stream['assocName']] = array(
				'className' => 'ContentStream.CsContentStream',
				'foreignKey' => $fk,
			);
		}
		$this->settings[$Model->alias] = $options;
		$Model->__createLinks();
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
			return !trigger_error('CsContentStreamHolderBehavior::normalizeConfig - ContentStream.streams must be a array indexed by type of content stream.');
		
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