<?php
/* Picture Fixture generated on: 2010-11-30 15:11:27 : 1291144827 */
class PictureFixture extends CakeTestFixture {
	var $name = 'Picture';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'galery_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'file_upload_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => array('id', 'galery_id', 'file_upload_id'), 'unique' => 1), 'fk_pictures_galeries' => array('column' => 'galery_id', 'unique' => 0), 'fk_pictures_file_uploads1' => array('column' => 'file_upload_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'galery_id' => 1,
			'file_upload_id' => 1,
			'title' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>