<?php

// Script to create the first user groups
// Intended to be ran through the jj_console; 
// Paste it on the console.

./cake jj_console
App::import('Model','JjUsers.UserGroup');
$ug = ClassRegistry::init('JjUsers.UserGroup');
:$ug->save(array('UserGroup' => array('name' => 'Todos os usuarios','alias' => 'all_users')))
$ug->create()
:$ug->save(array('UserGroup' => array('name' => 'Administradores',  'alias' => 'admin',     'parent_id' => 1))) 
$ug->create()
:$ug->save(array('UserGroup' => array('name' => 'Editores',         'alias' => 'editors',   'parent_id' => 2))) 
$ug->create()
:$ug->save(array('UserGroup' => array('name' => 'Redatores',        'alias' => 'redactors', 'parent_id' => 2)))
$ug->create()
:$ug->save(array('UserGroup' => array('name' => 'Tecnicos',         'alias' => 'techies',   'parent_id' => 2)))
$ug->create()
:$ug->save(array('UserGroup' => array('name' => 'Superusuarios',    'alias' => 'superusers','parent_id' => 2)))
quit

./cake jj_console
App::import('Component', 'Auth');
App::import('Model','JjUsers.UserUser');
$ug = ClassRegistry::init('JjUsers.UserGroup');
$auth = ClassRegistry::init('AuthComponent');
$pass = $auth->password('1234');
:$ug->UserUser->save(array('UserUser' => array('name' => 'Eleonora C. Albano','username' => 'albano@unicamp.br','password' => $pass, 'user_group_id' => 3)))
$ug->UserUser->create();
:$ug->UserUser->save(array('UserUser' => array('name' => 'Lucas Vignoli','username' => 'lucas@preface.com.br','password' => $pass, 'user_group_id' => 5)))
$ug->UserUser->create();
:$ug->UserUser->save(array('UserUser' => array('name' => 'Daniel Abrahao','username' => 'daniel@preface.com.br','password' => $pass, 'user_group_id' => 5)))
$ug->UserUser->create();
:$ug->UserUser->save(array('UserUser' => array('name' => 'Rodrigo Caravita','username' => 'rodrigo@preface.com.br','password' => $pass, 'user_group_id' => 5)))
$ug->UserUser->create();
:$ug->UserUser->save(array('UserUser' => array('name' => 'Super-usuario','username' => 'preface@preface.com.br','password' => $pass, 'user_group_id' => 6)))
$ug->UserUser->create();
:$ug->UserUser->save(array('UserUser' => array('name' => 'Teste de Redator','username' => 'redator@preface.com.br','password' => $pass, 'user_group_id' => 4)))
quit
