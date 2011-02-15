<?php
class UserUser extends JjUsersAppModel {
	var $name = 'UserUser';
	var $validate = array(
		'user_group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty')
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty')
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'UserGroup' => array(
			'className' => 'UserGroup',
			'foreignKey' => 'user_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>