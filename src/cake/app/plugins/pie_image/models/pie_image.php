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

class PieImage extends PieImageAppModel
{
/**
 * Model name.
 * 
 * @var string
 * @access public
 */
	var $name = 'PieImage';

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
 * belongsTo relationship
 * 
 * @var array
 * @access 
 */
	var $belongsTo = array(
		'SfilStoredFile' => array(
			'className' => 'JjMedia.SfilStoredFile',
			'foreignKey' => 'file_id'
		)
	);

/**
 * Used to keep the current file_id and delete it, if changed.
 * 
 * @var false|string
 * @access protected
 */
	protected $oldFileId = false;

/**
 * beforeSave callback
 * 
 * @access public
 * @param array $options
 * @return true Always return true.
 */
	function beforeSave($options)
	{
		$this->oldFileId = false;
		if ($this->id)
			$this->oldFileId = $this->field('file_id');
		
		return true;
	}

/**
 * afterSave callback
 * 
 * If file_id changes, erases the old one.
 * 
 * @access public
 * @param boolean $created If the register was created or was not.
 */
	function afterSave($created)
	{
		if (!$created && !empty($this->oldFileId) && $this->oldFileId != $this->data[$this->alias]['file_id'])
			$this->SfilStoredFile->delete($this->oldFileId);
	}
}