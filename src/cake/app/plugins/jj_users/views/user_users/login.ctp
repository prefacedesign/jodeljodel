<?php
echo $session->flash('auth');    
echo $this->Bl->p('Login para a página administrativa');
echo $this->Form->create('UserUser', array('action' => 'login'));    
echo $this->Form->input('username', array(
	'label' => __('Login page: username label', true)
));    
echo $this->Form->input('password', array(
	'label' => __('Login page: password label', true)
));
echo $this->Form->end(__('Login page: Enter',true));
echo $this->Bl->floatBreak();