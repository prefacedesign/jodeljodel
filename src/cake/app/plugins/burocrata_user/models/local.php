<?php
	class Local extends BurocrataUserAppModel
	{
		var $name = 'Local';

		var $hasMany = array('BurocrataUser.Event');

	}