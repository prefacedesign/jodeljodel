<?php
/* NewsNew Fixture generated on: 2011-02-25 11:02:44 : 1298643224 */
class NewsNewFixture extends CakeTestFixture {
	var $name = 'NewsNew';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'auth_author_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_news_news_auth_authors' => array('column' => 'auth_author_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'auth_author_id' => 1,
			'date' => '2011-02-25 11:13:44',
			'created' => '2011-02-25 11:13:44',
			'modified' => '2011-02-25 11:13:44'
		),
	);
}
?>