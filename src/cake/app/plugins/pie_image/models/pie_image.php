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
	
/** saveCorkContent
 *
 *  This function is demanded by the Corktile contract. Basically, it must
 *  insert the data in a table row. If an 'id' is given in the content, it
 *  should update the data.
 *
 *  @param array $content The data that must be saved. If empty it should be filled with
 *                        the default content.
 *  @param array $options Special options related to this type of Cork. In the
 *						  case of the TextCork this data can be:
 *						    - 'maxLenght' => maximum lenght of chars it must have 
 *							- 'minLenght' => minimum lenght of chars it should have
 *                          - 'textile' => if set to true it should
 *  @param boolean $fromForm It should be set from true, if the data sent is being
 *							 sent directly from the Form.
 *  @return The saved data ID on success. False on failure.
 */ 
	function saveCorkContent($content = array(), $options = array(), $fromForm = false)
	{
		if (empty($content))
		{
			$content['PieImage']['title'] = __("", true);
		}
		if ($this->save($content))
		{
			return $this->id;
		}
		else
		{
			return false;
		}
	}

/** getCorkContent
 *
 *  This function is demanded by the Corktile contract. Basically, it must
 *  return the Model data for a given id.
 *
 *  @param $id The id of the row to be retrieved
 *  @param Array $options If it should be variations on the regular behavior,
 *                        these options should be passed to this array.
 *                        In the special case of the text_cork there aren't
 *  @return The data ID on success. False on failure.
 */ 
	function getCorkContent($id, $options = array())
	{
		return $this->find('first', array('conditions' => array('PieImage.id' => $id), 'contain' => array()));
	}
}
