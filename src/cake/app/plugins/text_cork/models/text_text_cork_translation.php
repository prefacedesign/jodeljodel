<?php
class TextTextCorkTranslation extends TextCorkAppModel {
	var $name = 'TextTextCorkTranslation';

	var $belongsTo = array(
		'TextTextCork' => array(
			'className' => 'TextCork.TextTextCork',
			'foreignKey' => 'text_text_cork_id'
		)
	);
}
?>