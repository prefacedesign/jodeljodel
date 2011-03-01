<?php
class EveEventTranslation extends EventAppModel {
	var $name = 'EveEventTranslation';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'EveEvent' => array(
			'className' => 'Event.EveEvent',
			'foreignKey' => 'eve_event_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>