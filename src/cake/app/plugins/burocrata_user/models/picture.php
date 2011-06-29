<?php
class Picture extends BurocrataUserAppModel {
	var $name = 'Picture';
	
	var $actsAs = array(
		'JjUtils.Ordered' => array(
			'field' => 'weight',
			'foreign_key' => 'galery_id'
		)
	);
	
	var $validate = array(
		'galery_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'file_upload_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);

	var $belongsTo = array(
		'Galery' => array(
			'className' => 'BurocrataUser.Galery',
			'counterCache' => true
		),
		'SfilStoredFile' => array(
			'className' => 'JjMedia.SfilStoredFile',
			'foreignKey' => 'file_upload_id'
		)
	);
	
	var $file_upload_id;
	
	function beforeDelete($cascade = true)
	{
		if ($cascade)
		{
			$this->recursive = -1;
			$this->file_upload_id = $this->field('file_upload_id');
		}
		return true;
	}
	
	function afterDelete()
	{
		if ($this->file_upload_id)
			$this->SfilStoredFile->delete($this->file_upload_id);
	}
}
?>