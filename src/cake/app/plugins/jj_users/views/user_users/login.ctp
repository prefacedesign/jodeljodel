<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

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