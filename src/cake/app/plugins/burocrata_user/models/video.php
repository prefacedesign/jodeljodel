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
			'foreignKey' => 'video_id',
			'associationForeignKey' => 'person_id',
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
	
	
	
	var $actsAs = array(
	'Tags.Taggable' => array(
		'separator' => ',',
		'field' => 'tags',
		'tagAlias' => 'Tag',
		'tagClass' => 'Tags.Tag',
		'taggedClass' => 'Tags.Tagged',
		'foreignKey' => 'foreign_key',
		'associationForeignKey' => 'tag_id',
		'automaticTagging' => true,
		'unsetInAfterFind' => false,
		'resetBinding' => false,
	));
	
	function saveBurocrata($data)
	{
		//debug($data);
		return $this->saveAll($data);
	}
	
}