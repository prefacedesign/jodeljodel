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

class UserProfile extends JjUsersAppModel
{
	var $name = 'UserProfile';
	
	var $actsAs = array(
		'Containable', 
	);
	
	
	var $validate = array(
		'name' => array(
			'notempty' => array('rule' => array('notempty'))
		),
		'slug' => array(
			'notempty' => array('rule' => array('notempty')),
		),
		'description' => array(
			'notempty' => array('rule' => array('notempty')),
		)
	);
	
	var $hasAndBelongsToMany = array(
		'UserPermission' => array(
			'className' => 'JjUsers.UserPermission', 
			'joinTable' => 'user_profiles_user_permissions',
		),
		'UserUser' => array(
			'className' => 'JjUsers.UserUser',
			'joinTable' => 'user_users_user_profiles',
			'unique' => false
		)
	);

	function backDelete($id)
	{
		$this->contain('UserUser');
		$data = $this->findById($id);
		if (!empty($data['UserUser']))
			return false;
		return $this->delete($id);
	}
	
/**
 * Creates a blank row in the table. It is part of the backstage contract.
 */
	function createEmpty()
	{
		$saved = $this->saveAll(array($this->alias => array()), array('validate' => false));
		if ($saved)
			return $this->id;
		return false;
	}

/**
 * Ensures that all related users be updated forcing permission reload of logged users.
 * 
 * @access public
 */
	function afterSave()
	{
		$this->contain('UserUser');
		$data = $this->read();

		$usersId = Set::extract('/UserUser/id', $data);
		if (!empty($usersId))
		{
			$this->UserUser->updateAll(
				array('UserUser.modified' => '"' . date('Y-m-d H:i:s') . '"'),
				array('UserUser.id' => $usersId)
			);
		}
	}
}
