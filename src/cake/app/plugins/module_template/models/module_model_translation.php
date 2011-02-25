<?php
class PersPersonTranslation extends PersonAppModel {
	var $name = 'PersPersonTranslation';
	var $validate = array(
		'pers_person_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'PersPerson' => array(
			'className' => 'PersPerson',
			'foreignKey' => 'pers_person_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>