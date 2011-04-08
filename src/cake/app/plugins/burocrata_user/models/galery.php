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

	var $belongsTo = array(
		'UserUser' => array(
			'className' => 'JjUsers.UserUser'
		)
	);
	var $hasMany = array('Picture');
}