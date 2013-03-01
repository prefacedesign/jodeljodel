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
 * Media StoredFile Behavior
 *
 * This Behavior performs the deletion of belongsTo related contents automaticly.
 * Such thing is usefull when using the relationship belongsTo -> hasOne
 * and the related content can not "live" by itselft.
 *
 * To attach this Behavior, you need to especify all fields that holds 
 * one of these keys.
 * 
 * Ex.
 * {{{
 * 	var $actsAs = array(
 * 		'JjMedia.StoredFile' => array('img_id', 'img2_id', 'file_id')
 * 	);
 * }}}
 *
 * It will always use the SfilStoredFile! So dont even try to use this baby with 
 * another similar case.
 *
 * @package jj_media
 * @subpackage jj_media.models.behaviors
 */
class StoredFileHolderBehavior extends ModelBehavior
{
/**
 * Settings
 * 
 * @access public
 * @var array
 */
	public $settings = array();

/**
 * Bahavior property that holds all runtime variables. 
 * 
 * @var array
 * @access protected
 */
	protected $runtime;

/**
 * Behavior setup
 * 
 * @access public
 * @return void
 */
	public function setup(&$Model, $options = array())
	{
		if (!is_array($options))
			$options = array($options);
		
		$this->settings[$Model->alias]['keys'] = $options;
		$this->runtime[$Model->alias] = array();
	}

/**
 * beforeSave callback
 * 
 * @access public
 * @param array $options
 * @return true Always return true.
 */
	function beforeSave(&$Model, $options)
	{
		$this->runtime[$Model->alias]['ids_bkp'] = false;
		if ($Model->id)
		{
			$results = $Model->find('first', array(
					'recursive' => -1, 
					'fields' => $this->settings[$Model->alias]['keys'],
					'conditions' => array($Model->alias . '.' . $Model->primaryKey => $Model->id)
			));
			$this->runtime[$Model->alias]['ids_bkp'] = $results[$Model->alias];
		}
		
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
	function afterSave(&$Model, $created)
	{
		if (!$created && !empty($this->runtime[$Model->alias]['ids_bkp']))
		{
			$SfilStoredFile =& $this->getFileModel($Model);
			
			foreach ($this->settings[$Model->alias]['keys'] as $key)
			{
				if (empty($this->runtime[$Model->alias]['ids_bkp'][$key]))
					continue;
				if (isset($Model->data[$Model->alias][$key]) && $Model->data[$Model->alias][$key] != $this->runtime[$Model->alias]['ids_bkp'][$key])
					$SfilStoredFile->delete($this->runtime[$Model->alias]['ids_bkp'][$key]);
			}
		}
	}

/**
 * beforeDelete
 * 
 * @access public
 */
	public function beforeDelete($Model, $cascade)
	{
		$this->runtime[$Model->alias]['delete'] = array();
		$data = $Model->data;
		
		foreach ($this->settings[$Model->alias]['keys'] as $key)
		{
			if (empty($data[$Model->alias][$key]))
				$data = $Model->read();
			
			if (!empty($data[$Model->alias][$key]))
				$this->runtime[$Model->alias]['delete'][] = $data[$Model->alias][$key];
		}
		
		return true;
	}

/**
 * afterDelete
 * 
 * Used to delete any content_stream register.
 * 
 * @access public
 * @param Model $Model
 * @return void
 */
	public function afterDelete(&$Model)
	{
		if (!empty($this->runtime[$Model->alias]['delete']))
		{
			$SfilStoredFile =& $this->getFileModel($Model);
			
			foreach ($this->runtime[$Model->alias]['delete'] as $fk_id)
				$SfilStoredFile->delete($fk_id);
		}
		unset($this->runtime[$Model->alias]['delete']);
	}

/**
 * Function that searches the current model for the SfilStoredFile model, avoiding an ClassRegistry::init() call.
 * 
 * @access protected
 */
	protected function getFileModel(&$Model)
	{
		if (isset($Model->SfilStoredFile))
			$SfilStoredFile =& $Model->SfilStoredFile;
		else
			$SfilStoredFile =& ClassRegistry::init('JjMedia.SfilStoredFile');
		
		return $SfilStoredFile;
	}
}
