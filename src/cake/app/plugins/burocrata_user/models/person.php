<?php
class Person extends BurocrataUserAppModel {
	var $name = 'Person';
	var $displayField = 'name';

	var $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'message' => 'Probably, he or she has a name. What is it?'
		),
		'gender' => array(
			'rule' => array('inList', array('female', 'male'))
		)
	);
	
	var $hasMany = array(
		'Galery' => array(
			'className' => 'BurocrataUser.Galery'
		)
	);
	
	
	function findFilteredOptions($options = array())
	{
		if (empty($options))
			return $this->find('list');
		else
			return $this->find('list', array('conditions' => $options));
	}

}