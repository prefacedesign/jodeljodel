<?php

// Script to create the first users.
// Intended to be ran through the jj_console; 
// Paste it on the console.

App::import('Model','JjUsers.UserUser'); $uu = new UserUser();
:$uu->save(array('UserUser' => array('name' => 'Eleonora C. Albano','username' => 'albano@unicamp.br','password' => '2d55ecd820319381d0d20c924e33a3bf02dd90ee', 'user_group_id' => 3)))
$uu->create();
:$uu->save(array('UserUser' => array('name' => 'Lucas Vignoli','username' => 'lucas@preface.com.br','password' => '2d55ecd820319381d0d20c924e33a3bf02dd90ee', 'user_group_id' => 5)))
$uu->create();
:$uu->save(array('UserUser' => array('name' => 'Daniel Abrahao','username' => 'daniel@preface.com.br','password' => '2d55ecd820319381d0d20c924e33a3bf02dd90ee', 'user_group_id' => 5)))
$uu->create();
:$uu->save(array('UserUser' => array('name' => 'Rodrigo Caravita','username' => 'rodrigo@preface.com.br','password' => '2d55ecd820319381d0d20c924e33a3bf02dd90ee', 'user_group_id' => 5)))
$uu->create();
:$uu->save(array('UserUser' => array('name' => 'Super-usuario','username' => 'preface@preface.com.br','password' => '2d55ecd820319381d0d20c924e33a3bf02dd90ee', 'user_group_id' => 6)))
$uu->create();
:$uu->save(array('UserUser' => array('name' => 'Teste de Redator','username' => 'redator@preface.com.br','password' => '2d55ecd820319381d0d20c924e33a3bf02dd90ee', 'user_group_id' => 4)))