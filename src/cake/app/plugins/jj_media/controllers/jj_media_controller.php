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

/**
 * Media enhanced plugin
 *
 * Media JjMediaController
 *
 * @package jj_media
 * @subpackage jj_media.controllers
 */

class JjMediaController extends JjMediaAppController {

	var $name = 'JjMedia';
	var $view = 'Media';
	
	var $uses = array('JjMedia.SfilStoredFile');
	
	function index($sfil_stored_files_id = null, $filter = '')
	{
		if(!empty($sfil_stored_files_id))
		{
			$this->SfilStoredFile->contain();
			$file_data = $this->SfilStoredFile->findById($sfil_stored_files_id);
				
			if(!empty($file_data))
			{
				if (!empty($filter) && !empty($file_data['SfilStoredFile']['transformation']))
					$filter = $file_data['SfilStoredFile']['transformation'] . '_' . $filter;
				
				$download = false;
				$id = $name = $file_data['SfilStoredFile']['basename'];
				$extension = array_pop(explode('.', $id));
				if (!empty($file_data['SfilStoredFile']['original_filename']))
				{
					$name = explode('.', $file_data['SfilStoredFile']['original_filename']);
					if (count($name) > 1)
						array_pop($name);
					$name = implode('.', $name);
				}
				$mimeType = array($extension => $file_data['SfilStoredFile']['mime_type']);
				
				if (!empty($filter)) {
					$path = MEDIA_FILTER . $filter . DS;
				} else {
					$path = MEDIA_TRANSFER;
				}
				
				$path .= $file_data['SfilStoredFile']['dirname'] . DS;
				
				$this->set(compact('id', 'name', 'mimeType', 'download', 'path', 'extension'));
			}
		}
	}
	
	
	function upload()
	{
		$saved = $error = false;
		$validationErrors = array();
		
		if (!empty($this->data))
		{
			$saved = $this->SfilStoredFile->save($this->data);
			
			if ($saved == false)
				$validationErrors = $this->validateErrors($this->SfilStoredFile);
			else
				$saved = $this->SfilStoredFile->id;
		}
		
		$this->layout = 'ajax';
		
		echo json_encode(compact('error', 'validationErrors', 'saved'));
	}
}