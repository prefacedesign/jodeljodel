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

class UserGroup extends JjUsersAppModel {
	var $name = 'UserGroup';
	var $validate = array(
		'parent_id' => array(
			'numeric' => array(
				'rule' => array('numeric')
			),
		),
	);
	
	var $actsAs = array(
		'Containable', 
		'Tree',
		'Acl' => array('type' => 'requester'),
		'JjUsers.AddAliasToAcl' => array('type' => 'requester', 'field' => 'alias')
	);
	

	var $belongsTo = array(
		'ParentUserGroup' => array(
			'className' => 'UserGroup',
			'foreignKey' => 'parent_id'
		)
	);

	var $hasMany = array(
		'ChildUserGroup' => array(
			'className' => 'UserGroup',
			'foreignKey' => 'parent_id',
			'dependent' => false
		),
		'UserUser' => array(
			'className' => 'UserUser',
			'foreignKey' => 'user_group_id',
			'dependent' => false
		)
	);
	
	function parentNode()
	{
		if (!$this->id && empty($this->data)) 
			return null;    
		$data = $this->data;    		
		if (empty($this->data)) 
			$data = $this->read();
		
		if (empty($data['UserGroup']['parent_id']))
			return 'root_node';
		else	
			return array('UserGroup' => array('id' => $data['UserGroup']['parent_id']));
	}
	
	/*function afterSave($created)
	{
		if (isset($this->data['UserGroup']['alias']))
		{
			$node = $this->node(array('UserGroup' => array('id' => $this->id)));
			$Aro = ClassRegistry::init('Aro');
			$data = array('Aro' => array(
					'id' => $node[0]['Aro']['id'],
					'alias' => $this->data['UserGroup']['alias']
				)
			);
			
			$Aro->create();
			$Aro->save($data);
		}
	}*/

}
?>