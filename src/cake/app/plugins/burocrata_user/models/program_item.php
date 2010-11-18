<?php
	class ProgramItem extends BurocrataUserAppModel
	{
		var $name = 'ProgramItem';
	
		var $belongsTo = array('BurocrataUser.Event');
	}