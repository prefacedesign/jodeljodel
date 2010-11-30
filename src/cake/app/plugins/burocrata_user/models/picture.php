<?php
class Picture extends BurocrataUserAppModel {
	var $name = 'Picture';
	var $validate = array(
		'galery_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'file_upload_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Galery' => array(
			'className' => 'Galery',
			'foreignKey' => 'galery_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'FileUpload' => array(
			'className' => 'FileUpload',
			'foreignKey' => 'file_upload_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>