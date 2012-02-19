<?php
class UserUser extends JjUsersAppModel {
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
		if (!$this->id && empty($this->data)) 
			return null;    
		$data = $this->data;    		
		if (empty($this->data)) 
			$data = $this->read();
		
		return array('UserGroup' => array('id' => $data[$this->alias]['user_group_id']));
	}
}
?>
