<?php
class Comment extends BurocrataUserAppModel {
	var $name = 'Comment';
	var $validate = array(
		'thread_comment_id' => array(
			'numeric' => array(
				'rule' => array('numeric')
			)
		)
	);

	var $belongsTo = array(
		'ThreadComment' => array(
			'className' => 'BurocrataUser.ThreadComment',
			'counterCache' => true
		)
	);
}