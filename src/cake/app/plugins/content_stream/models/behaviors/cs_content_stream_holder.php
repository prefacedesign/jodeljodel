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
		$config = Configure::read('ContentStream');
	}
}