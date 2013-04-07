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

/**
 * Configurator class
 *
 * Clas for dealing with ContentStream config.
 *
 * PHP versions 5
 * 
 * @package		jodel
 * @subpackage	jodel.content_stream.libs
 */

/**
 * CsConfigurator.
 *
 * Just a CakePHP convention.
 * 
 * @package		jodel
 * @subpackage	jodel.content_stream.libs
 */
class CsConfigurator
{
/**
 * True if already loaded the configuration and 
 * 
 * @var boolean
 * @access protected
 */
	protected static $nomalized = false;

/**
 * Returns the ContentStream configuration.
 * 
 * @access public
 * @param string $subconfig
 * @return boolean|array 
 */
	static function getConfig($subconfig = false)
	{
		if (!App::import('Config', 'ContentStream.config'))
			return !trigger_error('CsConfigurator::getConfig() - Content stream configuration not found.');
		
		if (!self::$nomalized && !self::normalizeConfig())
			return array();
		
		if ($subconfig)
			return Configure::read('ContentStream.'.$subconfig);
		return Configure::read('ContentStream');
	}

/**
 * Creates all parameters on configuration using defaults, if not set.
 * The configuration is stored back in the Configure class.
 * 
 * @access public
 * @return boolean Return true if succefully nomalized, false, if not.
 */
	static function normalizeConfig()
	{
		$config = Configure::read('ContentStream');
		if (Configure::read() && (!is_array($config['streams']) || Set::numeric(array_keys($config['streams']))))
			return !trigger_error('CsConfigurator::normalizeConfig - ContentStream.streams must be a array indexed by type of content stream.');
		
		$config['streams'] = Set::normalize($config['streams']);
		foreach ($config['streams'] as $type => &$stream)
		{
			if (!isset($stream['model'])) $stream['model'] = Inflector::camelize($type) . '.' . Inflector::classify($type);
			if (!isset($stream['controller'])) $stream['controller'] = Inflector::pluralize($type);
			if (!isset($stream['title'])) $stream['title'] = Inflector::humanize($type);
		}
		
		Configure::write('ContentStream', $config);
		return self::$nomalized = true;
	}
}