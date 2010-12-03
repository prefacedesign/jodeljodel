<?php
class PersPerson extends PersonAppModel {
	var $name = 'PersPerson';
	var $validate = array(
		'auth_author_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'img_image_id' => array(
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

	/*var $belongsTo = array(
		'AuthAuthor' => array(
			'className' => 'AuthAuthor',
			'foreignKey' => 'auth_author_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ImgImage' => array(
			'className' => 'ImgImage',
			'foreignKey' => 'img_image_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);*/
}
?>