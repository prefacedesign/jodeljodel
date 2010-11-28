<?php
	class Event extends BurocrataUserAppModel
	{
		var $name = 'Event';
		
		var $belongsTo = array('BurocrataUser.Local');
		var $hasMany = array('BurocrataUser.ProgramItem');

	}