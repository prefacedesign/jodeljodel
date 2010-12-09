<?php
class Galery extends BurocrataUserAppModel {
	var $name = 'Galery';
	var $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Needs a owner',
				'required' => true
			)
		),
		'about' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'About missing',
				'required' => true
			)
		),
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Title missing',
				'required' => true
			)
		),
		'date' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => 'Not a valid date',
				'required' => false
			)
		)
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Picture' => array(
			'className' => 'Picture',
			'foreignKey' => 'galery_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>