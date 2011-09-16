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
		$item_type = $id = $action = $Model = null;
		$error = $this->BuroBurocrata->loadPostedModel($this, $Model);
		
		if (!$error)
		{
			if (isset($this->buroData['action']))
				$action = $this->buroData['action'];
			
			if (isset($this->buroData['type']))
				$item_type = $this->buroData['type'];
			
			switch ($action)
			{
				case 'edit':
					if (!empty($this->buroData['id']))
						$id = $this->buroData['id'];
					extract($this->BuroBurocrata->getViewData($this));
					$this->data = $data;
					$this->set(compact('data'));
				break;
			}
		}
		
		$this->set(compact('error', 'action', 'saved', 'id', 'item_type'));
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