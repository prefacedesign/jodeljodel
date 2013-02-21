<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 * Copyright 2007-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
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
 * its encode method. For now only 'serialize' is available.
 *
 * @access public
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
 * @access public
 * @param array $results The results of the find operation
 * @param boolean $primary Whether this model is being queried directly (vs. being queried as an association)
 * @return mixed Result of the find operation
 */	
	function afterFind(&$Model, $results, $primary = false) 
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
 * @access public
 * @return boolean True if the operation should continue, false if it should abort
 */
	function beforeSave(&$Model, $options = array())
	{
		$Model->data = $Model->encode($Model->data);
		return true;
	}

/**
 * Decodes all data based on configuration parameters.
 *
 * @access public
 * @param object A reference for the Model object
 * @param array $data
 * @return The array of modified data
 */		
	public function decode(&$Model, $data) 
	{
		$config = $this->settings[$Model->alias];
		foreach ($config['fields'] as $field => $method)
		{
			if (isset($data[$Model->alias][$field]))
			{
				$data[$Model->alias][$field] = $this->processData($data[$Model->alias][$field], $method, 'decode');
			}
		}
		return $data;
	}

/**
 * Encodes all data based on configuration parameters.
 *
 * @access public
 * @param object A reference for the Model object
 * @param array $data
 * @return The array of modified data
 */	
	public function encode(&$Model, $data)
	{
		$config = $this->settings[$Model->alias];
		foreach ($config['fields'] as $field => $method)
		{
			if (isset($data[$Model->alias][$field]))
			{
				$data[$Model->alias][$field] = $this->processData($data[$Model->alias][$field], $method, 'encode');
			}
		}
		return $data;
	}

/**
 * Caller for implemented processes
 * 
 * @access protected
 * @param mixed The data to be processed
 * @return Processed data
 */
	protected function processData($data, $process, $action)
	{
		$method = '_' . $process;
		if (!method_exists($this, $method))
		{
			trigger_error ('EncondableBehavior::encode() - Method '.$process.' not implemented for Encodable behavior.');
			return $data;
		}
		
		return $this->{$method}($data, $action);
	}

/**
 * Implements data encoding using the native PHP serialize/unserialize functions
 *
 * @access protected
 * @param array $data The data that will be serialized or unserialized
 * @param string $encodeOrDecode Specify what to do. Can be "encode" or "decode"
 * @return Encoded or decoded data.
 */		
	protected function _serialize($data, $encodeOrDecode = 'encode')
	{
		if ($encodeOrDecode == 'encode')
		{
			return is_array($data) ? @serialize($data) : $data;
		}
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
