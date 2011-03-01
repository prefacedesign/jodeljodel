<?php
class NewsNewTranslation extends PersonAppModel {
	var $name = 'NewsNewTranslation';
	var $validate = array(
		'news_new_id' => array(
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
		'NewsNew' => array(
			'className' => 'New.NewsNew',
			'foreignKey' => 'news_new_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>