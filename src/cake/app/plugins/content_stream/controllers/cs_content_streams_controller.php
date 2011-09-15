<?php

/**
 * Controller for content_stream plugin.
 *
 * PHP versions 5
 *
 * @package       jodel
 * @subpackage    jodel.content_stream.controllers
 */
 
App::import('Lib', 'JjUtils.SecureParams');


/**
 * BuroBurocrataController.
 *
 * All burocrata`s ajax requests points here by default.
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.controllers
 */
class CsContentStreamsController extends ContentStreamAppController
{
/**
 * Class name
 * 
 * @var string
 * @access public
 */
	public $name = 'CsContentStreams';

/**
 * List of models
 *
 * @var array
 * @access public
 */
	public $uses = array('ContentStream.CsContentStream');

/**
 * List of components
 *
 * @var array
 * @access public
 */
	public $components = array('Typographer.TypeLayoutSchemePicker', 'Burocrata.BuroBurocrata', 'RequestHandler');

/**
 * Default View object to use
 *
 * @var string
 * @access public
 */
	public $view = 'JjUtils.Json';
	
/**
 * Main action on this controller
 * 
 * @access public
 */
	function action()
	{
	}

/**
 * 
 * 
 * @access 
 */
	function save()
	{
	}
}