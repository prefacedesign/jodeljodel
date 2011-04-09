<?php
class Picture extends BurocrataUserAppModel {
	var $name = 'Picture';
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
		)
	);
	
	var $hasOne = array(
		'SfilStoredFile' => array(
			'className' => 'JjMedia.SfilStoredFile',
			'foreignKey' => 'file_upload_id'
		)
	);
}
?>