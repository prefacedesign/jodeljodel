<?php
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