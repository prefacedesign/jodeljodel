<?php
/**
 * Copyright 2010, Preface Design (http://preface.com.br) 
 * Copyright 2007-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2007-2010, Cake Development Corporation (http://cakedc.com)
 * @copyright 2010, Preface Design (http://preface.com.br)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * This Behavior was based on the CakeDC Serializeable Behavior released on 2010
 * under the same software license.
 */

/**
 * JjUtils Plugin
 *
 * JjUtils Encodable Behavior allows for one to stored encoded data
 * in fields. It is encoded on save, and decoded on find.
 *
 * @package jj_utils
 * @subpackage jj_utils.models.behaviors
 */
class EncodableBehavior extends ModelBehavior {

/**
 * Settings
 * 
 * @var mixed
 */
	public $settings = array();

/**
 * Default settings
 * 
 * @var array
 */
	protected $_defaults = array('fields' => array());

/**
 * Setup
 *
 * One must give an array with every field that is encoded, and
 * its encode method. For now only 'serializable' is available.
 *
 * @param object AppModel
 * @param array $config Sample config is array('fields' => array('data' => 'serialize', 'other_data_field' => 'base64'));
 */
	public function setup(&$model, $config = array()) 
	{
		$settings = array_merge($this->_defaults, $config);
		$this->settings[$model->alias] = $settings;
	}
	
/**
 * After find callback
 *
 * Decodes the data according to enconding in settings.
 *
 * @param mixed $results The results of the find operation
 * @param boolean $primary Whether this model is being queried directly (vs. being queried as an association)
 * @return mixed Result of the find operation
 */	
	function afterFind($Model, $results, $primary = false) 
	{
		$config = $this->settings[$Model->alias];
	
		if (!empty($results)) 
		{
			foreach($results as $key => $result) 
			{
				$results[$key] = $Model->decode($result);
			}
		}
		return $results;
	}

/**
 * Called before each save operation
 *
 * @return boolean True if the operation should continue, false if it should abort
 */
	function beforeSave(&$Model, $options = array()) 
	{
		$Model->data = $Model->encode($Model->data);
		return true;
	}
	
/**
 * Decodes all data.
 *
 * @param string $matchId
 * @param array $data
 * @return boolean
 */	
	public function decode($Model, &$data) 
	{
		$config = $this->settings[$Model->alias];
	
		foreach ($config['fields'] as $field => $method)
		{
			if (isset($data[$Model->alias][$field]))
				$data[$Model->alias][$field] = $this->{'_' . $method}($data[$Model->alias][$field], 'decode');
		}
		return $data;
	}

/**
 * Encodes all data.
 *
 * @param string $matchId
 * @param array $data
 * @return boolean
 */	
	public function encode($Model, &$data) 
	{
		$config = $this->settings[$Model->alias];
		foreach ($config['fields'] as $field => $method)
		{
			if (isset($data[$Model->alias][$field]))
				$data[$Model->alias][$field] = $this->{'_' . $method}($data[$Model->alias][$field], 'encode');
		}
		return $data;
	}
	
/**
 * 
 *
 * @param boolean $matchId
 * @param array $data
 * @return Encoded or decoded data.
 */		
	private function _serialize($data, $encodeOrDecode = 'encode')
	{
		if ($encodeOrDecode == 'encode')
			return is_array($data) ? @serialize($data) : $data;
		else
		{
			if (is_string($data))
			{
				$data = @unserialize($data);
				if ($data === false)
					$data = array();
			}
			else
			{
				$data = array();
			}
			return $data;
		}
	}
}
