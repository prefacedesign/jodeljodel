<?php

class Local extends BurocrataUserAppModel
{
	var $name = 'Local';
	var $displayField = 'name';
	var $hasMany = array('BurocrataUser.Event');
}