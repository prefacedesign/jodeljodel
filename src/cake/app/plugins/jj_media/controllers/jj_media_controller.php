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
		if (!empty($filter))
		{
			$filter = explode('|', $filter);
		}
		
		if($sfil_stored_files_id)
		{
			$this->SfilStoredFile->contain();
			$dados = $this->SfilStoredFile->findById($sfil_stored_files_id);
			
			if(!empty($dados))
			{
				// todo: find the file path using the data 
				$download = true;
				$id = $name = $dados['SfilStoredFile']['basename'];
				$extension = array_pop(explode('.', $id));
				if (!empty($dados['SfilStoredFile']['original_filename']))
				{
					$name = explode('.', $dados['SfilStoredFile']['original_filename']);
					if (count($name) > 1)
						array_pop($name);
					$name = implode('.', $name);
				}
				$mimeType = array($extension => $dados['SfilStoredFile']['mime_type']);
				$path = 'media' . DS . 'transfer' . DS . 'img' . DS;
				
				$this->set(compact('id', 'name', 'mimeType', 'download', 'path', 'extension'));
			}
		}
	}
}
?>