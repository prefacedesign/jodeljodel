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
 * Corktile version of this plugin
 *
 * PHP versions 5
 * 
 * @package		jodel
 * @subpackage	jodel.content_stream.models
 */

/**
 * CsCork.
 *
 * A model for content stream corktiles.
 * 
 * @package		jodel
 * @subpackage	jodel.content_stream.models
 */
class CsCork extends ContentStreamAppModel
{
/**
 * Model name.
 * 
 * @var string
 * @access public
 */
	var $name = 'CsCork';

/**
 * List of behaviors
 * 
 * @var array
 * @access public
 */
	var $actsAs = array(
		'Containable', 
		'Corktile.CorkAttachable' => array('type' => 'cs_cork'),
	);

/**
 * Method called by the model CorkCorktile when saving
 * 
 * @access public
 * @param array $content Content to be saved
 * @param array $options The options passed
 * @param boolean $fromForm
 * @return false|string If the saving went ok, returns the ID. Else, returns false.
 */
	function saveCorkContent($content = array(), $options = array(), $fromForm = false)
	{
		if (!isset($options['options']['cs_type']))
			$options['options']['cs_type'] = 'cork';
		
		$content['CsCork']['type'] = $options['options']['cs_type'];
		$this->attachContentStream($options['options']['cs_type']);
		
		if ($this->save($content))
			return $this->id;
		else
			return false;
	}

/**
 * Used to populate the corktile view.
 * 
 * @access public
 * @param string $id
 * @param array $options
 * @return array The data from database.
 */
	function getCorkContent($id, $options = array())
	{
		$this->contain();
		$data = $this->findById($id);
		
		$this->attachContentStream($data[$this->alias]['type']);
		return $data;
	}
/**
 * Overwrites the default Model::delete()
 * 
 * This is used to make possible attach the CsContentStreamHolder
 * 
 * @access public
 * @param string $id
 * @return The result from parent::delete()
 */
	function delete($id)
	{
		$this->id = $id;
		$this->read();
		$this->attachContentStream($this->data[$this->alias]['type']);
		return parent::delete();
	}

/**
 * Method that attach the CsContentStreamHolder
 * 
 * @access protected
 * @param string $cs_type The type of content stream to attach.
 */
	protected function attachContentStream($cs_type)
	{
		if (!$this->Behaviors->attached('CsContentStreamHolder'))
			$this->Behaviors->attach('ContentStream.CsContentStreamHolder', array(
				'streams' => array('cs_content_stream_id' => $cs_type)
			));
	}
}