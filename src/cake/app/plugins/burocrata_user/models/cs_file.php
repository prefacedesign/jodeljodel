<?php
class CsFile extends ContentStreamTestAppModel
{
	var $name = 'CsFile';
	var $actsAs = array('Containable');
	var $belongsTo = array(
		'SfilStoredFile' => array(
			'className' => 'JjMedia.SfilStoredFile',
			'foreignKey' => 'file_id'
		)
	);
	
	function findContentStream($id)
	{
		$this->contain(array('SfilStoredFile'));
		return $this->findById($id);
	}
}