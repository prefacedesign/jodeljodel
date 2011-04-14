<?php
	echo $this->Bl->b(array(), array(), 'Nome: ');
	echo $this->Bl->p(array(), array(), $data['Person']['name']);
	
	$now = strtotime('now');
	$birthday = strtotime($data['Person']['birthdate']);
	$age = 0;
	while($now > $birthday = strtotime('+1 year', $birthday))
		++$age;
	
	echo $this->Bl->b(array(), array(), 'Birthday: ');
	echo $this->Bl->p(array(), array(), $data['Person']['birthdate'] . ' (' . $age . ' years)');
	
	echo $this->Bl->b(array(), array(), 'Number of galleries: ');
	echo $this->Bl->p(array(), array(), $data['Person']['galery_count']);
	
	echo '<br />';