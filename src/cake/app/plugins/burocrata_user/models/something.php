<?php
class Something extends BurocrataUserAppModel
{
	var $name = 'Something';
	
	var $order = array('Something.modified' => 'DESC');
	
	var $belongsTo = array(
		'Galery' => array('className' => 'BurocrataUser.Galery')
	);
}