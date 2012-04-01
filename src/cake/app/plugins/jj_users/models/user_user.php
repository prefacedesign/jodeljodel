<?php
class UserUser extends JjUsersAppModel
{
	var $name = 'UserUser';
	
	var $actsAs = array(
		'Containable', 
		'Acl' => array('type' => 'requester'), 
		'JjUsers.AddAliasToAcl' => array('type' => 'requester', 'field' => 'username')
	);
	
	var $validate = array(
		'user_group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty')
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty')
			),
		),
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
			$user_group_id = $data[$this->alias]['user_group_id'];
		} elseif ($this->id) {
			$user_group_id = $this->field('user_group_id');
		} else {
			return null;
		}

		return array('UserGroup' => array('id' => $user_group_id));
	}
	}
}
?>
