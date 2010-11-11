<?php
/* ProgramItem Fixture generated on: 2010-11-11 11:11:21 : 1289483661 */
class ProgramItemFixture extends CakeTestFixture {
	var $name = 'ProgramItem';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'event_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'begin' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'end' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => array('id', 'event_id'), 'unique' => 1), 'fk_program_itens_events' => array('column' => 'event_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'event_id' => 1,
			'begin' => '2010-11-11 11:54:21',
			'end' => '2010-11-11 11:54:21',
			'type' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>