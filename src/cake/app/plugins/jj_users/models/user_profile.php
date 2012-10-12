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
		)
	);
	
	
	function backDelete($id)
	{
		$this->bindModel(array(
			'hasMany' => array(
				'UserUsersUserProfile' => array(
					'className' => 'jjUsers.UserUsersUserProfile',
				)
			)
		));
		
		$this->UserUsersUserProfile->deleteAll(array('user_profile_id' => $id), false);
		return $this->delete($id);
	}
	
	/* Creates a blank row in the table. It is part of the backstage contract.
	 *
	 */
	function createEmpty()
	{
		
		$data = $this->saveAll(array($this->alias => array()), array('validate' => false));
		$data = $this->find('first', array('conditions' => array($this->alias.'.id' => $this->id)));
		
		return $data;
	}
	
}
