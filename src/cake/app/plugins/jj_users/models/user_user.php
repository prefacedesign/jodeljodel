<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

class UserUser extends JjUsersAppModel
{
	var $name = 'UserUser';
	
	var $virtualFields = array(
		'full_name' => 'CONCAT(COALESCE(UserUser.name,""), " ", COALESCE(UserUser.surname,""))'
	);
	
	var $actsAs = array(
		'Containable', 
	);
	
	var $validate = array(
		'name' => array(
			'notempty' => array('rule' => array('notempty'))
		),
		'email' => array(
			'notempty' => array('rule' => array('notempty')),
			'email' => array('rule' => array('email'))
		),
		'username' => array(
			'notempty' => array('rule' => array('notempty')),
		),
		'password_change' => array(
			'notempty' => array('rule' => array('notempty')),
			'minLength' => array('rule' => array('minLength', 6), 'message' => 'A senha deve conter no mínimo 6 caracteres.')
		),
		'password_retype' => array(
			'same' => array('rule' => array('identicalFieldValues', 'password_change'))
		),
	);

	
	var $hasAndBelongsToMany = array('UserProfile' => array('className' => 'JjUsers.UserProfile', 'joinTable' => 'user_users_user_profiles'));
	
	
	/* Creates a blank row in the table. It is part of the backstage contract.
	 *
	 */
	function createEmpty()
	{
		
		$data = $this->saveAll(array(), array('validate' => false));
		$data = $this->find('first', array('conditions' => array($this->alias.'.id' => $this->id)));
		
		return $data;
	}
	
	function saveBurocrata($data)
	{	
		App::import('Component','JjUsers.JjAuth');
		
		$this->set($data);
		
		if ($this->validates()) {
			if (!empty($data[$this->alias]['password_change'])) {
				$data[$this->alias]['password'] = JjAuthComponent::password($data[$this->alias]['password_change']);
			}
			
			return $this->saveAll($data);
		}
		else {
			return false;
		}
	}
	
	function beforeValidate($options)
	{
		if (empty($this->data[$this->alias]['password_change']) && empty($this->data[$this->alias]['password_retype']))
			unset($this->data[$this->alias]['password_change'], $this->data[$this->alias]['password_retype']);
			
		if ((!isset($this->data['UserProfile']['UserProfile']) || empty($this->data['UserProfile']['UserProfile'])) && isset($this->data[$this->alias]['validate_profiles'])) 
		{
			$this->invalidate('non_existent_field'); // fake validation error on Profile
			$this->UserProfile->invalidate('UserProfile', 'Por favor, selecione ao menos um perfil');
		}
		return true;
	}
}
