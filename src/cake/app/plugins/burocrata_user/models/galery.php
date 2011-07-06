<?php

class Galery extends BurocrataUserAppModel {
	var $name = 'Galery';
	var $validate = array(
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
		)
	);

	var $belongsTo = array(
		'Person' => array(
			'className' => 'BurocrataUser.Person',
			'counterCache' => true
		)
	);
	
	var $hasMany = array(
		'Picture' => array(
			'className' => 'BurocrataUser.Picture',
			'order' => 'Picture.weight'
		),
		'Something' => array(
			'className' => 'BurocrataUser.Something',
			'order' => array('Something.some_text' => 'asc')
		)
	);
	
	
	
	
}