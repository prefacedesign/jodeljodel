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


class JodelUserShell extends Shell
{
	var $UserGroup;
	var $UserUser;

/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function startup()
	{
		App::import('Model','JjUsers.UserUser');
		$this->UserGroup =& ClassRegistry::init('JjUsers.UserGroup');
		$this->UserUser =& $this->UserGroup->UserUser;
	}

/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function main()
	{
		// Usage:
		// ./cake jodel_user create_group "Editors Inc." editors parent_group
		// ./cake jodel_user add "Full Name" username@preface.com.br p4ss3or& group_alias
		// ./cake jodel_user remove username@gmail.com
		// ./cake jodel_user 
		$this->_welcome();
		$this->out();
		$this->out('What is your business here?');
		
		do
		{
			$this->nl();
			$this->out(' User related procedures:');
			$this->out('  (ul) List all users');
			$this->out('  (ua) Add new user');
			$this->out('  (ud) Delete existent user');
			$this->out('  (um) Move user from a group to another');
		
			$this->nl();
			$this->out(' Group related procedures:');
			$this->out('  (gl) List groups');
			$this->out('  (ga) Add one user group');
			$this->out('  (gd) Delete one user group');
		
			$this->nl();
			$this->out(' (q) Quit');

			$op = $this->in('Choose one option', array('gl', 'ga', 'gd', 'ul', 'ua', 'ud', 'um', 'q'));
			
			$this->out();
			switch ($op)
			{
				case 'ul': $this->list_all(); break;
				case 'ua': $this->add(); break;
				case 'ud': $this->delete(); break;
				case 'um': $this->move(); break;
			
				case 'gl': $this->group_list(); break;
				case 'ga': $this->group_add(); break;
				case 'gd': $this->group_delete(); break;
			}
			$this->out(PHP_EOL);
		} while ($op != 'q');
	}
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function add()
	{
		App::import('Component', 'Auth');
		$data['name'] = $data['username'] = $data['password'] = $data['user_group_id'] = '';
		
		// Get name
		if (isset($this->args[0]))
			$data['name'] = array_shift($this->args);
		while (empty($data['name']))
		{
			$this->out();
			$data['name'] = trim($this->in('What is the user full name?'));
		}
		
		// Get username
		if (isset($this->args[0]))
			$data['username'] = array_shift($this->args);
		while (empty($data['username']))
		{
			$this->out();
			$data['username'] = trim($this->in('What is the username?'));
		}
		
		// Get the password
		if (isset($this->args[0]))
			$data['password'] = array_shift($this->args);
		while (empty($data['password']))
		{
			$this->out();
			$data['password'] = trim($this->in('What is the password?', false));
		}
		$auth = ClassRegistry::init('AuthComponent');
		$data['password'] = $auth->password($data['password']);
		
		// Get the user group
		if (isset($this->args[0]))
		{
			$groups = $this->UserGroup->find('all', array(
				'contain' => false,
				'conditions' => array(
					'or' => array(
						'alias' => $this->args[0],
						'name LIKE' => '%'.$this->args[0].'%'
					)
				)
			));
			if (count($groups) == 1)
				$data['user_group_id'] = $groups[0]['UserGroup']['id'];
		}
		
		while (empty($data['user_group_id']))
		{
			$list = $this->UserGroup->find('list', array('fields' => array('alias', 'id')));
			$options = array_keys($list);
			$options[] = 'c';

			$this->out();
			$alias = $this->in('Choose one user group:'.PHP_EOL.' '.implode(PHP_EOL.' ', array_keys($list)).PHP_EOL.'or (c) to cancel', $options);
			
			if ($alias == 'c')
				return;
			
			if (isset($list[$alias]))
				$data['user_group_id'] = $list[$alias];
		}
		
		$this->UserUser->create(array('UserUser' => $data));

		if ($this->UserUser->save())
			$this->out('New user \''.$data['name'].'\' added!' . PHP_EOL);
		else
			$this->error('Adding new user failed.' . PHP_EOL);
	}
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function delete()
	{
		$username = '';
		if (isset($this->args[0]))
			$username = array_shift($this->args);
		
		do
		{
			while (empty($username))
				$username = $this->in('What is the user username whose account will be removed? (c) to cancel');
			
			if ($username == 'c')
				return;
			
			$user = $this->UserUser->find('first', array('conditions' => compact('username'), 'contain' => false));
			if (empty($user))
				$this->out('User `'.$username.'` not found! Try again...');
			$username = '';
		} while (empty($user));
		
		if ($this->UserUser->delete($user['UserUser']['id']))
			$this->out('User successfully deleted!' . PHP_EOL);
		else
			$this->error('Deleting user failed.' . PHP_EOL);
	}
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function list_all()
	{
		$users = $this->UserUser->find('all', array());
		
		$name_length = max(array_map('mb_strlen', Set::extract('/UserUser/name', $users))) + 2;
		$username_length = max(array_map('mb_strlen', Set::extract('/UserUser/username', $users))) + 4;
		
		foreach ($users as $user)
		{
			$out = str_pad($user['UserUser']['name'], $name_length);
			$out .= str_pad('(' . $user['UserUser']['username'] . ')', $username_length);
			$out .= $user['UserGroup']['alias'];
			$this->out($out);
		}
		
	}
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function move()
	{
		$username = '';
		if (isset($this->args[0]))
			$username = array_shift($this->args);
		
		do
		{
			while (empty($username))
				$username = $this->in('What is the user username whose account will be changed? (c) to cancel');
			
			if ($username == 'c')
				return;
			
			$user = $this->UserUser->find('first', array('conditions' => compact('username'), 'contain' => false));
			if (empty($user))
				$this->out('User `'.$username.'` not found! Try again...');
			$username = '';
		} while (empty($user));
		
		
		// Get the user group
		$user['UserUser']['user_group_id'] = $this->getGroup();
		
		if ($this->UserUser->save($user))
			$this->out('User successfully updated!');
		else
			$this->error('Updating user failed.');
	}
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function group_list()
	{
		$groups = $this->UserGroup->find('threaded', array('contain' => false));
		$this->printGroupTree($groups);
	}
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function group_add()
	{
		// Get the name
		$group['name'] = '';
		if (isset($this->args[0]))
			$group['name'] = array_shift($this->args);
		while (empty($group['name']))
			$group['name'] = $this->in('What is the name for this new user group?');
		
		// Get the alias
		$group['alias'] = '';
		if (isset($this->args[0]))
			$group['alias'] = array_shift($this->args);
		do
		{
			while (empty($group['alias']))
				$group['alias'] = $this->in('What is the alias for this new user group?', false, strtolower(Inflector::slug($group['name'])));
			$count = $this->UserGroup->find('count', array(
				'contain' => false, 
				'conditions' => array('alias' => $group['alias'])
			));
			if ($count)
			{
				$this->out();
				$this->out('There is already one user group with the choosen alias. Choose another one.');
				$group['alias'] = '';
			}
		} while ($count != 0 || empty($group['alias']));
		
		// Get the parent
		if (!isset($this->params['no-parent']))
		{
			$this->out();
			$group['parent_id'] = $this->getGroup('Now, select one group to be the parent of this new one');
			if (empty($group['parent_id']))
			{
				$this->error('No parent group selected. Creating group failed.');
				return;
			}
		}
		
		$this->UserGroup->create(array('UserGroup' => $group));
		if ($this->UserGroup->save())
			$this->out('Group \''.$group['alias'].'\' successfully created');
		else
			$this->error('It was not possible to create the new group.');
	}
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function group_delete()
	{
		$group_id = $this->getGroup();
		$users = $this->UserUser->find('count', array(
			'conditions' => array('UserUser.user_group_id' => $group_id), 
			'contain' => false
		));
		if ($users)
		{
			$this->error('The group is not empty. Before deletion, remove all users from it.');
			return;
		}
		
		if ($this->UserGroup->delete($group_id))
			$this->out('Group successfully deleted' . PHP_EOL);
		else
			$this->error('It was not possible to delete the group.' . PHP_EOL);
	}
/**
 * method description
 * 
 * @access protected
 * @return type description
 */
	protected function printGroupTree($data, $deep = 0)
	{
		foreach ($data as $value)
		{
			$pad = str_pad('', $deep * 2);
			$this->out($pad . $value['UserGroup']['name'] . ' (' . $value['UserGroup']['alias'] . ')');
			if ($value['children'])
				$this->printGroupTree($value['children'], $deep+1);
		}
	}
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function getGroup($msg = 'Choose one user group')
	{
		if (isset($this->args[0]))
		{
			$groups = $this->UserGroup->find('all', array(
				'contain' => false,
				'conditions' => array(
					'alias' => $this->args[0],
				)
			));
			if (count($groups) == 1)
				return $groups[0]['UserGroup']['id'];
		}
		
		while (empty($data['user_group_id']))
		{
			$list = $this->UserGroup->find('list', array('fields' => array('alias', 'id')));
			$options = array_keys($list);
			$options[] = 'c';

			$this->out();
			$alias = $this->in($msg.':'.PHP_EOL.' '.implode(PHP_EOL.' ', array_keys($list)).PHP_EOL.'or (c) to cancel', $options);
			
			if ($alias == 'c')
				return false;
			
			if (isset($list[$alias]))
				return $list[$alias];
		}
		return false;
	}
}
