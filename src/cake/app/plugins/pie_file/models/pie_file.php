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

class PieFile extends PieFileAppModel
{
/**
 * Model name
 * 
 * @var string
 * @access public
 */
	var $name = 'PieFile';

/**
 * Behaviors
 * 
 * @access public
 */
	var $actsAs = array(
		'Containable',
		'JjMedia.StoredFileHolder' => array('file_id')
	);

/**
 * belongs to relatioship
 * 
 * @var array
 * @access public
 */
	var $belongsTo = array(
		'SfilStoredFile' => array(
			'className' => 'JjMedia.SfilStoredFile',
			'foreignKey' => 'file_id'
		)
	);

/**
 * Find called on ContentStream
 * 
 * @access public
 */
	function findContentStream($id)
	{
		$this->contain('SfilStoredFile');
		return $this->findById($id);
	}
}