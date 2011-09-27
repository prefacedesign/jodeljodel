<?php
/**
 * Copyright 2010-2011, Preface Design
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010-2011, Preface Design
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::import('Lib', array('JjUtils.SecureParams'));

/**
 * Media enhanced plugin
 *
 * Media JjMediaController
 *
 * @package jj_bedia
 * @subpackage jj_bedia.controllers
 */
class JjMediaController extends JjMediaAppController {
/**
 * Controller name
 * 
 * @var string
 * @access public
 */
	var $name = 'JjMedia';

/**
 * Dont uses models, a priori.
 * 
 * @var string
 * @access public
 */
	var $uses = array();

/**
 * List of components
 *
 * @var string
 * @access public
 */
	public $components = array('Typographer.TypeLayoutSchemePicker', 'RequestHandler', 'Burocrata.BuroBurocrata');

/**
 * Layout Scheme
 * 
 * @var string
 * @access public
 */
	public $layout_scheme;

/**
 * beforeFilter callback for allow anyone to have access
 * And properly load the bricklayer helper
 * 
 * @access public
 * @todo Better user filtering
 */
	function beforeFilter()
	{
		parent::beforeFilter();
		if ($this->Auth)
			$this->Auth->allow('*');
	}

/**
 * index action
 *
 * Used to view or download the uploaded files via media plugin
 * If one needs to download only, than the url must be index/1/id,filter,checksum
 * else, the url must be like index/id,filter,checksum
 * 
 * ### This URL is routed:
 * - `/vw/id,filter,checksum` routes to `index/1/id,filter,checksum` (force download)
 * - `/dl/id,filter,checksum` routes to `index/id,filter,checksum`
 * 
 * @access public
 * @param mixed $one Could be a string containing the packed parameters
 *                   or a int that will be converted to boolean to especify if force download or not
 * @param mixed $two If $one parameter is a boolean, this param receive the 
 *                   packed parameters
 */
	function index($one = null, $two = null)
	{
		$this->view = 'Media';
		$cache = true; $modified = null; $download = false;
		
		$packed_parameters = $one;
		if (!is_null($two))
		{
			$packed_parameters = $two;
			$download = (boolean) $one;
		}
		
		$unpacked = SecureParams::unpack($packed_parameters);
		if (count($unpacked) != 2)
			$this->cakeError('error404');
		
		$model_name = 'JjMedia.SfilStoredFile';
		if (!$this->loadModel($model_name))
			return;
		
		list($sfil_stored_files_id, $version) = $unpacked;
		list($plugin, $model_name) = pluginSplit($model_name);
		$model_alias = $this->{$model_name}->alias;
		
		if(!empty($sfil_stored_files_id))
		{
			$this->{$model_name}->contain();
			$file_data = $this->{$model_name}->findById($sfil_stored_files_id);
			
			if(!empty($file_data))
			{
				if (!empty($version) && !empty($file_data[$model_alias]['transformation']))
					$version = $file_data[$model_alias]['transformation'] . '_' . $version;
				
				$id = $name = $file_data[$model_alias]['basename'];
				$modified = $file_data[$model_alias]['modified'];
				$extension = array_pop(explode('.', $id));
				if (!empty($file_data[$model_alias]['original_filename']))
				{
					$name = explode('.', $file_data[$model_alias]['original_filename']);
					if (count($name) > 1)
						array_pop($name);
					$name = implode('.', $name);
				}
				$mimeType = array($extension => $file_data[$model_alias]['mime_type']);
				
				if (!empty($version)) {
					$path = MEDIA_FILTER . $version . DS;
				} else {
					$path = MEDIA_TRANSFER;
				}
				
				$path .= $file_data[$model_alias]['dirname'] . DS;
				
				$this->set(compact('id', 'name', 'mimeType', 'download', 'path', 'extension', 'cache', 'modified'));
			}
		}
	}


/**
 * upload action
 *
 * Used to receive upload from a form, containing the data from upload on data[MODEL][file].
 * It already saves the file, generating the filtered copies, and renders a JSON, directly on view.
 * 
 * @access public
 * @todo Receive, through posted data, the model that will handle the save
 */
	function upload()
	{
		$saved = $error = false;
		$filename = '';
		$validationErrors = array();
		
		$version = $fieldName = $model_name = null;
		
		if (!empty($this->buroData['data']))
			list($version, $fieldName, $model_name) = SecureParams::unpack($this->buroData['data']);
		
		if (is_null($version) || is_null($fieldName) || is_null($model_name))
			$error = Configure::read()>0?'JjMediaController::upload - Configuration data not available.':true;
		
		if ($error === false && !$this->loadModel($model_name))
			$error = Configure::read()>0?'JjMediaController::upload - Model '.$model_name.' not found.':true;
		
		if ($error === false)
		{
			list($plugin, $model_name) = pluginSplit($model_name);
			$model_alias = $this->{$model_name}->alias;
			
			if (!empty($this->data))
			{
				$scope = $this->{$model_name}->findTheScope($fieldName);
				if ($scope)
					$this->{$model_name}->setScope($scope);
				$saved = $this->{$model_name}->save($this->data);
				
				if ($saved == false)
					$validationErrors = $this->validateErrors($this->{$model_name});
				else
					$saved = $this->{$model_name}->id;
				
				if ($saved)
				{
					$filename = $this->data[$model_alias]['file']['name'];
					list($fieldModelName, $fieldName) = pluginSplit($fieldName);
					if (!empty($this->data[$fieldModelName][$fieldName]))
						$this->{$model_name}->delete($this->data[$fieldModelName][$fieldName]);
				}
			}
		}
		$this->layout = 'ajax';
		$this->view = 'Typographer.Type';
		$this->set(compact('error', 'validationErrors', 'saved', 'version', 'filename'));
	}
}