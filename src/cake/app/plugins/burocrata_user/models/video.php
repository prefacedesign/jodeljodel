<?php

class Video extends BurocrataUserAppModel {
	var $name = 'Video';
	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Title missing',
				'required' => true
			)
		)
	);
	
	
	var $hasAndBelongsToMany = array(
		'Person' => array(
			'className' => 'BurocrataUser.Person',
			'joinTable' => 'people_videos',
			'foreignKey' => 'person_id',
			'associationForeignKey' => 'video_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
}