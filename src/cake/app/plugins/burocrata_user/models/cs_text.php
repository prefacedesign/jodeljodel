<?php
class CsText extends BurocrataUserAppModel
{
	var $name = 'CsText';
	
	var $validate = array(
		'text' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);
}