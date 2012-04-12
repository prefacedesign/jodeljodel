<?php
class UserUser extends JjUsersAppModel
{
	var $name = 'UserUser';
	
	var $virtualFields = array(
		'full_name' => 'CONCAT(COALESCE(UserUser.name,""), " ", COALESCE(UserUser.surname,""))'
	);
	
	var $actsAs = array(
		'Containable', 
		'Acl' => array('type' => 'requester'), 
		'JjUsers.AddAliasToAcl' => array('type' => 'requester', 'field' => 'username')
	);
	
	var $validate = array(
		'user_group_id' => array(
			'numeric' => array('rule' => array('numeric')),
		),
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
			'minLength' => array('rule' => array('minLength', 6))
		),
		'password_retype' => array(
			'same' => array('rule' => array('identicalFieldValues', 'password'))
		)
	);

	var $belongsTo = array(
		'UserGroup' => array(
			'className' => 'UserGroup',
			'foreignKey' => 'user_group_id'
		)
	);
	
	function parentNode()
	{
		if (!$this->id && $this->data[$this->alias][$this->primaryKey]) {
			$this->id = $this->data[$this->alias][$this->primaryKey];
		}
		
		if (!empty($this->data[$this->alias]['user_group_id'])) {
			$user_group_id = $this->data[$this->alias]['user_group_id'];
		} elseif ($this->id) {
			$user_group_id = $this->field('user_group_id');
		} else {
			return null;
		}

		return array('UserGroup' => array('id' => $user_group_id));
	}
	
	function beforeValidate($options)
	{
		if (empty($this->data[$this->alias]['password_change']) && empty($this->data[$this->alias]['password_retype']))
			unset($this->data[$this->alias]['password_change'], $this->data[$this->alias]['password_retype']);
		return true;
	}
}
