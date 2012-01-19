<?php

class JodelUserShell extends Shell
{
	public function startup()
	{
	}
	
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
			$this->out(' Group related procedures:');
			$this->out('  (gl) List groups');
			$this->out('  (ga) Add one user group');
			$this->out('  (gd) Delete one user group');
		
			$this->nl();
			$this->out(' User related procedures:');
			$this->out('  (ul) List all users');
			$this->out('  (ua) Add new user');
			$this->out('  (ud) Delete existent user');
			$this->out('  (um) Move user from a group to another');
		
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
	
	public function add()
	{
		App::import('Component', 'Auth');
		App::import('Model','JjUsers.UserUser');
		$ug = ClassRegistry::init('JjUsers.UserGroup');
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
			$groups = $ug->find('all', array(
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
			$list = $ug->find('list', array('fields' => array('alias', 'id')));
			$options = array_keys($list);
			$options[] = 'c';

			$this->out();
			$alias = $this->in('Choose one user group:'.PHP_EOL.' '.implode(PHP_EOL.' ', array_keys($list)).PHP_EOL.'or (c) to cancel', $options);
			
			if ($alias == 'c')
				return;
			
			if (isset($list[$alias]))
				$data['user_group_id'] = $list[$alias];
		}
		
		$ug->UserUser->create(array('UserUser' => $data));

		if ($ug->UserUser->save())
			$this->out('New user added!');
		else
			$this->error('Adding new user failed.');
	}
	
	public function delete()
	{
		App::import('Model','JjUsers.UserUser');
		$uu = ClassRegistry::init('JjUsers.UserUser');
		
		$username = '';
		if (isset($this->args[0]))
			$username = array_shift($this->args);
		
		do
		{
			while (empty($username))
				$username = $this->in('What is the user username whose account will be removed? (c) to cancel');
			
			if ($username == 'c')
				return;
			
			$user = $uu->find('first', array('conditions' => compact('username'), 'contain' => false));
			if (empty($user))
				$this->out('User `'.$username.'` not found! Try again...');
			$username = '';
		} while (empty($user));
		
		if ($uu->delete($user['UserUser']['id']))
			$this->out('User successfully deleted!');
		else
			$this->error('Deleting user failed.');
	}
	
	public function list_all()
	{
		App::import('Model','JjUsers.UserUser');
		$uu = ClassRegistry::init('JjUsers.UserUser');
		
		$users = $uu->find('all', array());
		
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
	
	public function move()
	{
		App::import('Model','JjUsers.UserUser');
		$uu = ClassRegistry::init('JjUsers.UserUser');
		$ug =& $uu->UserGroup;
		
		$username = '';
		if (isset($this->args[0]))
			$username = array_shift($this->args);
		
		do
		{
			while (empty($username))
				$username = $this->in('What is the user username whose account will be changed? (c) to cancel');
			
			if ($username == 'c')
				return;
			
			$user = $uu->find('first', array('conditions' => compact('username'), 'contain' => false));
			if (empty($user))
				$this->out('User `'.$username.'` not found! Try again...');
			$username = '';
		} while (empty($user));
		
		
		// Get the user group
		if (isset($this->args[0]))
		{
			$groups = $ug->find('all', array(
				'contain' => false,
				'conditions' => array(
					'or' => array(
						'alias' => $this->args[0],
						'name LIKE' => '%'.$this->args[0].'%'
					)
				)
			));
			if (count($groups) == 1)
				$user['UserUser']['user_group_id'] = $groups[0]['UserGroup']['id'];
		}
		
		while (empty($user['UserUser']['user_group_id']))
		{
			$list = $ug->find('list', array('fields' => array('alias', 'id')));
			$options = array_keys($list);
			$options[] = 'c';

			$this->out();
			$alias = $this->in('Choose one user group:'.PHP_EOL.' '.implode(PHP_EOL.' ', array_keys($list)).PHP_EOL.'or (c) to cancel', $options);
			
			if ($alias == 'c')
				return;
			
			if (isset($list[$alias]))
				$user['UserUser']['user_group_id'] = $list[$alias];
		}
		
		if ($uu->save($user))
			$this->out('User successfully updated!');
		else
			$this->error('Updating user failed.');
	}
}
