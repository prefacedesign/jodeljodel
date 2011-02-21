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
App::import('Config', array('JjMedia.Core'));

/**
 * Media enhanced plugin
 *
 * Media JjMediaController
 *
 * @package jj_media
 * @subpackage jj_media.controllers
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
 * beforeFilter callback for allow anyone to have access
 * 
 * @access public
 * @todo Better user filtering
 */
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('*');
	}


/**
 * index action
 *
 * Used to view or download the uploaded files via media plugin
 * If one needs to download only, than the url must be index/1/id,filter,checksum
 * else, the url must be like index/id,filter,checksum
 * 
 * Probably, those URLs will be masked by a Router config
 * 
 * @access public
 * @param mixed $one Could be a string containing the packed parameters
 *                   or a int that will be converted to boolean
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
		$validationErrors = array();
		
		$model_name = 'JjMedia.SfilStoredFile';
		if (!$this->loadModel($model_name))
			return;
		
		if (!empty($this->data))
		{
			$scope = $this->_findTheScope($this->data);
			if ($scope)
				$this->SfilStoredFile->setScope($scope);
			$saved = $this->SfilStoredFile->save($this->data);
			
			if ($saved == false)
				$validationErrors = $this->validateErrors($this->SfilStoredFile);
			else
				$saved = $this->SfilStoredFile->id;
		}
		
		$this->layout = 'ajax';
		$this->autoRender = false;
		echo json_encode(compact('error', 'validationErrors', 'saved'));
	}


/**
 * This method finds on posted data the input name that will receive the id of the uploaded file.
 * Based on its name, this method returns the current scope for get the filters.
 * 
 * @access protected
 * @param array $data The posted data
 * @return string|boolean The scope if found, or false if not
 */
	protected function _findTheScope($data = array())
	{
		if (empty($data) || !is_array($data))
			return null;
		
		$fieldName = false;
		foreach ($data as $modelName => $modelData)
		{
			if ($modelName == 'SfilStoredFile')
				continue;
			
			$fieldName = $modelName . '.' . array_shift(array_keys($modelData));
			break;
		}
		
		if ($fieldName)
		{
			$filters = Configure::read('Media.filter_plus');
			foreach ($filters as $scope => $filter)
			{
				if (!isset($filter['fields']) || !is_array($filter['fields']))
					continue;
				if (in_array($fieldName, $filter['fields']))
					return $scope;
			}
		}
		return null;
	}
}