<?php
class ThreadComment extends BurocrataUserAppModel {
	var $name = 'ThreadComment';
	var $validate = array(
		'galery_id' => array(
			'numeric' => array(
				'rule' => array('numeric')
			)
		)
	);

	var $belongsTo = array(
		'Galery' => array(
			'className' => 'BurocrataUser.Galery'
		)
	);

	var $hasMany = array(
		'Comment' => array(
			'className' => 'BurocrataUser.Comment'
		)
	);
}