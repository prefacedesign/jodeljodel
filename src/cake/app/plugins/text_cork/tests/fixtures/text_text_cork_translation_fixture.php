<?php
/* TextTextCorkTranslation Fixture generated on: 2011-02-27 21:02:40 : 1298854720 */
class TextTextCorkTranslationFixture extends CakeTestFixture {
	var $name = 'TextTextCorkTranslation';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'text_text_cork_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'language' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'text' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_text_text_cork_translations_text_text_corks1' => array('column' => 'text_text_cork_id', 'unique' => 0), 'k_lang_id' => array('column' => array('text_text_cork_id', 'language'), 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'text_text_cork_id' => 1,
			'language' => 'L',
			'text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);
}
?>