<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

/**
 * Main behavior for this plugin
 *
 * PHP versions 5
 * 
 * @package		jodel
 * @subpackage	jodel.content_stream.models
 */

App::import('Lib', 'ContentStream.CsConfigurator');

/**
 * CsContentStreamHolderBehavior.
 *
 * A model that must be atached to models that will use a content stream input.
 * 
 * @package		jodel
 * @subpackage	jodel.content_stream.models
 */
class CsContentStreamHolderBehavior extends ModelBehavior
{
/**
 * Bahavior property that holds all settings. 
 * This property is populated on setup() and is accessed on BuroBurocrataHelper
 * 
 * @var array
 * @access public
 */
	public $settings;

/**
 * Bahavior property that holds all runtime variables. 
 * 
 * @var array
 * @access protected
 */
	protected $runtime;

/**
 * This var is used to finish a transaction process when creating a new ContentStream
 * 
 * @var boolean
 * @access protected
 */
	protected $transactionContentStream = false;

/**
 * Invoke the normalization method and populates the $settings property.
 * 
 * After populates the settings, with all used values (with default values when not set),
 * this method create one belongsTo relationship with CsContentStream model for each
 * ContentStream.
 * 
 * ### The options:
 * - 
 * 
 * After this method executed, the settings should be like:
 * {{{
 * 	[ModelAlias] => array(
 *		[streams] => array
 *			[one_foreign_key] => array(
 *				[assocName] => array(
 *				[allowedContents] => array(
 *					[content_type_one] => array(
 *						'model' => 'ContentPlugin.ContentModel',
 *						'title' => 'Content title',
 *					),
 *					[content_type_two] => array( ... ),
 *					.
 *					.
 *					.
 *				)
 *			),
 *			[another_foreign_key] => array(
 *				.
 *				.
 *				.
 *			)
 *		)
 *	)
 * }}}
 * 
 * @param model $Model The model where this behavior is attached
 * @param array $options Configuration options.
 * @access public
 */
	function setup(&$Model, $options)
	{
		if (!isset($options['streams']) || empty($options['streams']) || !is_array($options['streams']) || Set::numeric(array_keys($options['streams'])))
			return !trigger_error('CsContentStreamHolderBehavior::setup - The `streams` parameter must be set on format: \'foreign_key\' => \'type\'');
		
		$config = CsConfigurator::getConfig();
		
		$type = $have = $callbacks = $assocName = null;
		foreach ($options['streams'] as $fk => &$stream)
		{
			if (!is_array($stream)) 
				$stream = array('type' => $stream);
			
			if (isset($options['allowedContents']))
				$stream['allowedContents'] = $options['allowedContents'];
			elseif (isset($stream['type']) && is_string($stream['type']) && isset($config['types'][$stream['type']]))
				$stream['allowedContents'] = $config['types'][$stream['type']];
			else
				return !trigger_error('CsContentStreamHolderBehavior - It must be set `allowedContents`(array) or `type`(string). In case of `type` set, it must be configured on content_stream plugin.');
			
			foreach ($stream['allowedContents'] as $k=>$allowedContent)
			{
				if (!is_string($allowedContent))
					return !trigger_error('CsContentStreamHolderBehavior - Parameter allowed content must be an string.');
				elseif (!isset($config['streams'][$allowedContent]))
					return !trigger_error('CsContentStreamHolderBehavior - Content type `'.$allowedContent.'` not known.');
				
				$stream['allowedContents'][$allowedContent] = $config['streams'][$allowedContent];
				unset($stream['allowedContents'][$k]);
			}
			
			$stream['assocName'] = empty($stream['type']) ? Inflector::camelize($fk) : Inflector::camelize('cs_'.$stream['type']);
			$Model->belongsTo[$stream['assocName']] = array(
				'className' => 'ContentStream.CsContentStream',
				'foreignKey' => $fk,
			);
		}
		$this->settings[$Model->alias] = $options;
		$Model->__createLinks();
		
		$this->runtime[$Model->alias] = array();
	}

/**
 * beforeSave callback
 * 
 * Here is created a new ContentStream if not created yet for each stream.
 * Also, is started a Transaction that is completed on afterSave.
 * 
 * @access public
 * @param model $Model
 * @return boolean Always true, allowing the saving proccess to be continued
 */
	function beforeSave(&$Model)
	{
		if (!$Model->exists())
		{
			$this->transactionContentStream = $Model->getDataSource()->begin($Model);
			foreach ($this->settings[$Model->alias]['streams'] as $fk => $stream)
				if (empty($Model->data[$Model->alias][$fk]) && $Model->{$stream['assocName']}->createEmpty($stream['type']))
					$Model->data[$Model->alias][$fk] = $Model->{$stream['assocName']}->id;
		}
		
		return true;
	}

/**
 * afterSave callback method.
 * 
 * This callback is used to finalize the transation started on beforeSave
 * 
 * @access public
 * @param Model $Model
 * @param boolean $created
 */
	function afterSave(&$Model, $created)
	{
		if ($this->transactionContentStream)
		{
			if ($created) $Model->getDataSource()->commit($Model);
			else		  $Model->getDataSource()->rollback($Model);
			$this->transactionContentStream = false;
		}
	}

/**
 * beforeDelete callback
 * 
 * Used to retreive each ContentStream and store on the runtime variable.
 * 
 * @access public
 * @param Model $Model
 * @param boolean $cascade
 * @return true Always true, so de deleting proccess can be continued
 */
	function beforeDelete(&$Model, $cascade)
	{
		$this->runtime[$Model->alias]['delete'] = array();
		$data = $Model->data;
		
		foreach ($this->settings[$Model->alias]['streams'] as $fk => $stream)
		{
			if (empty($data[$Model->alias][$fk]))
				$data = $Model->read();
			$this->runtime[$Model->alias]['delete'][$stream['assocName']] = $data[$Model->alias][$fk];
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
	function afterDelete(&$Model)
	{
		if (!empty($this->runtime[$Model->alias]['delete']))
			foreach ($this->runtime[$Model->alias]['delete'] as $assocName => $cs_id)
				$Model->{$assocName}->delete($cs_id);
		unset($this->runtime[$Model->alias]['delete']);
	}
}
