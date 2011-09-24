<?php
class Something extends BurocrataUserAppModel
{
	var $name = 'Something';
	
	var $order = array('Something.some_text' => 'ASC');
	
	var $belongsTo = array(
		'Galery' => array('className' => 'BurocrataUser.Galery')
	);
	
	var $validate = array(
		'some_text' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);
}