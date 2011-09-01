<?php
echo $session->flash('auth');
echo $this->Form->create('UserUser', array('action' => 'login'));    
echo $this->Form->input('username', array(
	'label' => __d('backstage','Login page: username label', true)
));    
echo $this->Form->input('password', array(
	'label' => __d('backstage','Login page: password label', true)
));
echo $this->Form->end(__d('backstage','Login page: Enter',true));
echo $this->Bl->floatBreak();