<?php

// Script to create the first user groups
// Intended to be ran through the jj_console; 
// Paste it on the console.

App::import('Model','JjUsers.UserGroup'); $ug = new UserGroup();
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


