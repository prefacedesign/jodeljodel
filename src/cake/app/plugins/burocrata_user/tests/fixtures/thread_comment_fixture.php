<?php
/* ThreadComment Fixture generated on: 2011-04-12 12:04:29 : 1302621929 */
class ThreadCommentFixture extends CakeTestFixture {
	var $name = 'ThreadComment';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'galery_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'comment_count' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_thread_comments_galeries1' => array('column' => 'galery_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'galery_id' => 1,
			'comment_count' => 1
		),
	);
}
?>