<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

/**
 * Shell script for cleaning uploads that did not finish properly.
 * 
 * @package jodel.jj_media
 * @subpackage .vendors.shell
 */
class UploadGcShell extends Shell
{

/**
 * If verbose actions or not.
 * 
 * @access protected
 */
	protected $quiet = false;

/**
 * Overwriting parent method avoiding the default header
 * 
 * @access public
 */
	public function startup()
	{
		// intentionally left blank
	}

/**
 * The main method: where things happen
 * 
 * @access public
 */
	function main()
	{
		if (isset($this->params['quiet']))
		{
			$this->quiet = true;
		}

		$tmp = new Folder(TMP);
		$folders = reset($tmp->read()); // read only directories (array[0])

		foreach ($folders as $folder)
		{
			$tmp->cd(TMP);
			$tmp->cd($folder);
			$files = end($tmp->read()); // read only files (array[1])
			if (in_array('last_interaction', $files))
			{
				$file_interaction = (int) file_get_contents($tmp->pwd() . DS . 'last_interaction');

				// as each piece is 1Mb, this will give the user the chance of uploading at 13,7 kbps (1,7 kb/s)
				if (time() - $file_interaction > 600)
				{
					$this->out("Removing $folder");
					foreach ($files as $file)
						unlink($tmp->pwd() . DS . $file);
					$tmp->delete();
				}
			}
		}
	}

/**
 * Overwrites parent method to introduce the "quiet" variant
 * 
 * @access public
 */
	function out($msg = '')
	{
		if (!$this->quiet)
			parent::out($msg);
	}
}
