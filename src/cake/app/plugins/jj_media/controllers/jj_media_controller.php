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
	var $uses = array('JjMedia.SfilStoredFiles');

	function index($sfil_stored_files_id = null)
	{
		
	}
}
?>