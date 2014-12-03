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

App::import('Lib', array('JjUtils.SecureParams'));

/**
 * Media enhanced plugin
 *
 * Media JjMediaController
 *
 * @property SfilStoredFile $SfilStoredFile
 * @property TypeLayoutSchemePickerComponent $TypeLayoutSchemePicker
 * @property RequestHandlerComponent $RequestHandler
 * @property BuroBurocrataComponent $BuroBurocrata
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
	var $uses = array('JjMedia.SfilStoredFile');

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
		if (isset($this->JjAuth))
			$this->JjAuth->allow('*');
		$this->TypeLayoutSchemePicker->pick('backstage');
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
	function index($download = null, $data = null, $name = null)
	{
		$this->view = 'Media';
		$cache = true; $modified = null;
		
		$unpacked = SecureParams::unpack($data);

		if (count($unpacked) != 2)
			$this->cakeError('error404');
		
		list($sfil_stored_files_id, $version) = $unpacked;
		$model_alias = $this->SfilStoredFile->alias;
		
		if(!empty($sfil_stored_files_id))
		{
			$this->SfilStoredFile->contain();
			$file_data = $this->SfilStoredFile->findById($sfil_stored_files_id);
			
			if (empty($file_data))
				$this->cakeError('error404');

			if (empty($name) && !$download)
				$this->redirect(array($download, $data, $file_data[$this->SfilStoredFile->alias]['original_filename']), 301);

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
				
				header('Content-Disposition: filename="' . $name . '.' . $extension . '";');

				// Check (via header) if the client already have an copy on cache
				$assetFilemTime = filemtime($path . $id);
				$eTag = Security::hash( $assetFilemTime . filesize($path . $id) );
				if (env('HTTP_IF_NONE_MATCH') && env('HTTP_IF_NONE_MATCH') == $eTag)
				{
					header("HTTP/1.1 304 Not Modified");
					$this->_stop();
				}
				header("Etag: " . $eTag);

				$this->set(compact('id', 'name', 'mimeType', 'download', 'path', 'extension', 'cache', 'modified'));
			}
		}
	}

/**
 * upload action
 *
 * Receive upload form POST, containing the data from upload on data[MODEL][file].
 * It already saves the file, generating the filtered copies, and renders a JSON, directly on view.
 * 
 * @access public
 */
	function upload()
	{
		if ($this->RequestHandler->isAjax())
		{
			$this->performAjaxUpload();
			return;
		}

		$this->layout = 'ajax';
		$this->view = 'Typographer.Type';
		$this->set($this->saveUpload($this->data));
	}

/**
 * Method to receive and glue pieces togheter on a ajax upload
 *
 * This method is NOT a action. It is called at JjMediaController::upload()
 * when is detected that the upload is performed by a ajax request.
 * 
 * @access protected
 * @return void
 * @todo A garbage collector avoiding all the data that is left behind due errors
 */
	protected function performAjaxUpload()
	{
		$error = false;
		$version = '';
		
		$startByte = env('HTTP_X_UPLOADER_START_BYTE');
		$isLast = env('HTTP_X_UPLOADER_IS_LAST');
		$chunkSize = env('HTTP_X_UPLOADER_CHUNK_SIZE');

		$version = $fieldName = $modelName = null;
		if (!empty($this->buroData['data']))
		{
			list($version, $fieldName, $modelName) = SecureParams::unpack($this->buroData['data']);
			list($plugin, $modelName) = pluginSplit($modelName);
		}

		if (empty($this->data[$modelName]['file']['tmp_name']))
			$error = 'upload-failed';
		elseif (!file_exists($chunkFileName = $this->data[$modelName]['file']['tmp_name']))
			$error = 'upload-failed-no-tempfile';
		elseif (filesize($chunkFileName) != $chunkSize)
			$error = 'upload-failed-chunksize-wrong';

		if ($error)
			goto renderAjaxUpload;


		if (empty($this->data['hash']))
		{
			$n = 0;
			do {
				$hash = uniqid('', true);
			} while (file_exists(TMP . $hash));
			mkdir(TMP . $hash);
			chmod(TMP . $hash, 0777);
		}
		else
		{
			$hash = $this->data['hash'];
		}

		$chunkFile = fopen($chunkFileName, 'rb');
		$gluedFileName = TMP . $hash . DS . 'file';
		$gluedFile = fopen($gluedFileName, 'ab');
		chmod($chunkFileName, 0666);

		if (filesize($gluedFileName) != $startByte)
		{
			$error = 'chunk-doesnt-fit';
			$nextByte = filesize($gluedFileName);
			goto renderAjaxUpload;
		}

		if (!$chunkFile || !$gluedFile)
		{
			$error = 'reading-file-error';
			goto renderAjaxUpload;
		}

		fwrite($gluedFile, fread($chunkFile, filesize($chunkFileName)));
		fclose($chunkFile);
		fclose($gluedFile);

		// This file will tell the GC cron job to clean files when "abandoned"
		$lastInteractionFile = TMP . $hash . DS . 'last_interaction';
		file_put_contents($lastInteractionFile, time());
		chmod($lastInteractionFile, 0666);

		if ($isLast == 'yes')
		{
			$originalName = TMP . $hash . DS . $this->data['original_name'];
			rename($gluedFileName, $originalName);

			$data = array($modelName => array('file' => $originalName));
			$savedData = $this->saveUpload($data);

			// remove temporary dir
			unlink($originalName);
			unlink($lastInteractionFile);
			rmdir(TMP . $hash);

			if (!$savedData['saved'])
			{
				$validationErrors = $savedData['validationErrors'];
			}
			else
			{
				extract($savedData);
			}
		}
		else
		{
			$nextByte = filesize($gluedFileName);
		}

		renderAjaxUpload:
		$this->view = 'JjUtils.Json';
		$this->set('jsonVars', compact('error', 'validationErrors', 'saved', 'version', 'url', 'dlurl', 'hash', 'nextByte'));
	}

/**
 * Performs the logic of saving the upload data
 *
 * This method receive the POSTed data from each action (classic or ajax upload)
 * validates the upload and saves it.
 * The returned data is a array of the generated data (that will generally be
 * sent back to the view, through JSON object)
 *
 * @access protected
 * @param array $data The POSTed data to be analised and saved
 * @param string $forceModel When not null, will force a Model to be used, instead of the specified on POSTed data
 * @return array The array of data of generated data
 */
	protected function saveUpload($data, $forceModel = null)
	{
		$saved = $error = false;
		$filename = '';
		$validationErrors = array();

		$version = $fieldName = $modelName = null;
		if (!empty($this->buroData['data']))
			list($version, $fieldName, $modelName) = SecureParams::unpack($this->buroData['data']);

		if ($forceModel)
			$modelName = $forceModel;
		
		if (is_null($version) || is_null($fieldName) || is_null($modelName))
		{
			$validationErrors['file'] = 'post_max_size';
		}
		elseif (!$this->loadModel($modelName))
		{
			$error = Configure::read()>0?'JjMediaController::upload - Model '.$modelName.' not found.':true;
		}
		else
		{
			list($plugin, $modelName) = pluginSplit($modelName);
			$Model =& $this->{$modelName};
			$model_alias = $Model->alias;
			
			if (!empty($data))
			{
				$scope = $Model->findTheScope($fieldName);
				if ($scope)
					$Model->setScope($scope);
				
				$Model->set($data);
				$validationErrors = $this->validateErrors($Model);

				if (empty($validationErrors) && $Model->save(null, false))
				{
					$saved = $Model->id;
					if (isset($data[$model_alias]['file']['name']))
						$filename = $data[$model_alias]['file']['name'];

					list($fieldModelName, $fieldName) = pluginSplit($fieldName);
					if (!empty($data[$fieldModelName][$fieldName]))
						$Model->delete($data[$fieldModelName][$fieldName]);

					App::import('Lib', array('JjUtils.SecureParams'));
					$packed_params = SecureParams::pack(array($saved, $version), true);
					$baseUrl = array('plugin' => 'jj_media', 'controller' => 'jj_media', 'action' => 'index');
					$dlurl = Router::url($baseUrl + array('1', $packed_params));
					$url = Router::url($baseUrl + array($packed_params));
				}
			}
		}

		return compact('error', 'validationErrors', 'saved', 'version', 'filename', 'url', 'dlurl');
	}
}
