<?php
class User extends BurocrataUserAppModel {
	var $name = 'User';
	var $displayField = 'name';

	var $hasMany = array('Galery');

	var $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'message' => 'Probably, he or she has a name. What is it?'
		),
		'gender' => array(
			'rule' => array('inList', array('female', 'male'))
		)
	);
}
?>