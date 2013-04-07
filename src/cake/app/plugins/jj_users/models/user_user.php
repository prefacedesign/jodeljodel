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
			'rule' => 'notEmpty',
			'message' => 'Não deixe em branco'
		),
		'email' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
			'message' => 'Não deixe em branco'
			),
			'email' => array(
				'rule' => 'email'
			)
		),
		'username' => array(
			'rule' => 'notEmpty',
			'message' => 'Não deixe em branco'
		),
		'password_change' => array(
			'minLength' => array(
				'rule' => array('minLength', 6),
				'message' => 'A senha deve conter no mínimo 6 caracteres.'
			)
		),
		'password_retype' => array(
			'rule' => array('identicalFieldValues', 'password_change'),
			'message' => 'Deve ser igual ao campo anterior'
		)
	);

/**
 * Many to many relationship
 * 
 * @access 
 */
	var $hasAndBelongsToMany = array(
		'UserProfile' => array(
			'className' => 'JjUsers.UserProfile',
			'joinTable' => 'user_users_user_profiles'
		)
	);

/**
 * Creates a blank row in the table. It is part of the backstage contract.
 */
	function createEmpty()
	{
		if ($this->saveAll(array(), array('validate' => false)))
			return $this->id;
		return false;
	}

/**
 * Saves data from burocrata form
 *
 * This method does some data validation and manipulation mainly
 * with the password sent
 *
 * @access public
 * @param array $data Data to save
 */
	function saveBurocrata($data)
	{
		unset($data[$this->alias]['password']);

		$this->set($data);

		if ($this->validates())
		{
			if (!empty($data[$this->alias]['password_change']))
				$data[$this->alias]['password'] = Security::hash($data[$this->alias]['password_change'], null, true);
			
			return $this->save($data);
		}
		return false;
	}

/**
 * Some hard-coded validations
 * 
 * @access public
 */
	function beforeValidate($options)
	{
		if (empty($this->data[$this->alias]['password_change']) && empty($this->data[$this->alias]['password_retype']))
			unset($this->data[$this->alias]['password_change'], $this->data[$this->alias]['password_retype']);

		$currentPassword = $this->field('password');
		if (empty($currentPassword) && empty($this->data[$this->alias]['password_change']))
			$this->invalidate('password_change', __d('jj_user', 'Favor criar uma senha para o usuário.', true));
			
		if (empty($this->data['UserProfile']['UserProfile']) && isset($this->data[$this->alias]['validate_profiles'])) 
		{
			$this->invalidate('non_existent_field'); // fake validation error on Profile
			$this->UserProfile->invalidate('UserProfile', __d('jj_users', 'Por favor, selecione ao menos um perfil', true));
		}
		return true;
	}

	function findBurocrata($user_user_id)
	{
		$this->contain('UserProfile');
		return $this->findById($user_user_id);
	}
}
