<?php
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