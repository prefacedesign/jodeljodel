<?php
class UserGroup extends JjUsersAppModel {
	var $name = 'UserGroup';
	var $validate = array(
		'parent_id' => array(
			'numeric' => array(
				'rule' => array('numeric')
			),
		),
	);
	
	var $actsAs = array('Tree');
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'ParentUserGroup' => array(
			'className' => 'UserGroup',
			'foreignKey' => 'parent_id'
		)
	);

	var $hasMany = array(
		'ChildUserGroup' => array(
			'className' => 'UserGroup',
			'foreignKey' => 'parent_id',
			'dependent' => false
		),
		'UserUser' => array(
			'className' => 'UserUser',
			'foreignKey' => 'user_group_id',
			'dependent' => false
		)
	);

}
?>