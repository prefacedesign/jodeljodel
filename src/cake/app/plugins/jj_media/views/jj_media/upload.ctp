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

	$url = $dlurl = '';
	
	if ($saved)
	{
		$url = $this->Bl->fileURL($saved, $version);
		$dlurl = $this->Bl->fileURL($saved, $version, true);
	}
	
	echo json_encode(compact('error', 'validationErrors', 'saved', 'url', 'dlurl', 'filename'));