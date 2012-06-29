<?php

class JodelNewUserShell extends Shell
{
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
		$this->UserPermission =& ClassRegistry::init('JjUsers.UserPermission');
		$this->UserProfile =& ClassRegistry::init('JjUsers.UserProfile');
		$this->UserUser =& ClassRegistry::init('JjUsers.UserUser');
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
		// ./cake jodel_new_user 
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
			$this->out('  (uap) Add profile to user');
			
			$this->nl();
			$this->out(' Permissions related procedures:');
			$this->out('  (pl) List permissions');
			$this->out('  (pa) Add one permission');
			$this->out('  (pd) Delete one permission');
			
			$this->nl();
			$this->out(' Profile related procedures:');
			$this->out('  (prl) List profiles');
			$this->out('  (pra) Add one profile');
			$this->out('  (prd) Delete one profile');
			$this->out('  (prp) Connect permissions with profile');
			$this->out('  (prpa) Add permission to profile');
			
			$this->nl();
			$this->out(' (q) Quit');

			$op = $this->in('Choose one option', array('prl', 'pra', 'prd', 'prp', 'prpa', 'pl', 'pa', 'pd', 'ul', 'ua', 'ud', 'uap', 'q'));
			
			$this->out();
			switch ($op)
			{
				case 'ul': $this->list_all(); break;
				case 'ua': $this->add(); break;
				case 'ud': $this->delete(); break;
				case 'uap': $this->user_profile_add(); break;
				
				case 'pl': $this->permission_list(); break;
				case 'pa': $this->permission_add(); break;
				case 'pd': $this->permission_delete(); break;
				
				case 'prl': $this->profile_list(); break;
				case 'pra': $this->profile_add(); break;
				case 'prd': $this->profile_delete(); break;
				case 'prp': $this->profile_permission(); break;
				
				case 'prpa': $this->profile_permission_add(); break;
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
		App::import('Component', 'JjUsers.JjAuth');
		$data['UserUser']['name'] = $data['UserUser']['username'] = $data['UserUser']['password'] = '';
		
		// Get name
		if (isset($this->args[0]))
			$data['UserUser']['name'] = array_shift($this->args);
		while (empty($data['UserUser']['name']))
		{
			$this->out();
			$data['UserUser']['name'] = trim($this->in('What is the user full name?'));
		}
		
		// Get username
		if (isset($this->args[0]))
			$data['UserUser']['username'] = array_shift($this->args);
		while (empty($data['UserUser']['username']))
		{
			$this->out();
			$data['UserUser']['username'] = trim($this->in('What is the username?'));
		}
		
		// Get the password
		if (isset($this->args[0]))
			$data['UserUser']['password'] = array_shift($this->args);
		while (empty($data['UserUser']['password']))
		{
			$this->out();
			$data['UserUser']['password'] = trim($this->in('What is the password?', false));
		}
		$auth = ClassRegistry::init('JjAuthComponent');
		$data['UserUser']['password'] = $auth->password($data['UserUser']['password']);
		
		// Get the user profile
		if (isset($this->args[0]))
		{
			$profiles = $this->UserProfile->find('all', array(
				'contain' => false,
				'conditions' => array(
					'or' => array(
						'slug' => $this->args[0],
						'name LIKE' => '%'.$this->args[0].'%'
					)
				)
			));
			if (count($profiles) == 1)
				$data['UserProfile'][] = $profiles[0]['UserProfile']['id'];
		}
		
		$this->UserUser->create();
		
		if ($this->UserUser->saveAll($data))
			$this->out('New user \''.$data['UserUser']['name'].'\' added!' . PHP_EOL);
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
			$this->out($out);
		}
		
	}

/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function permission_list()
	{
		$permissions = $this->UserPermission->find('all', array());
		
		$name_length = max(array_map('mb_strlen', Set::extract('/UserPermission/name', $permissions))) + 2;
		$slug_length = max(array_map('mb_strlen', Set::extract('/UserPermission/slug', $permissions))) + 4;
		$description_length = max(array_map('mb_strlen', Set::extract('/UserPermission/description', $permissions))) + 6;
		
		foreach ($permissions as $permission)
		{
			$out = str_pad($permission['UserPermission']['name'], $name_length);
			$out .= str_pad('(' . $permission['UserPermission']['slug'] . ')', $slug_length);
			$out .= str_pad('(' . $permission['UserPermission']['description'] . ')', $description_length);
			$this->out($out);
		}
	}
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function permission_add()
	{
		// Get the name
		$permission['name'] = '';
		if (isset($this->args[0]))
			$permission['name'] = array_shift($this->args);
		while (empty($permission['name']))
			$permission['name'] = $this->in('What is the name for this new permission?');
		
		// Get the slug
		$permission['slug'] = '';
		if (isset($this->args[0]))
			$permission['slug'] = array_shift($this->args);
		do
		{
			while (empty($permission['slug']))
				$permission['slug'] = $this->in('What is the slug for this new permission?', false, strtolower(Inflector::slug($permission['name'])));
			$count = $this->UserPermission->find('count', array(
				'contain' => false, 
				'conditions' => array('slug' => $permission['slug'])
			));
			if ($count)
			{
				$this->out();
				$this->out('There is already one permission with the choosen slug. Choose another one.');
				$permission['slug'] = '';
			}
		} while ($count != 0 || empty($permission['slug']));
		
		
		$this->UserPermission->create(array('UserPermission' => $permission));
		if ($this->UserPermission->save())
			$this->out('Permission \''.$permission['slug'].'\' successfully created');
		else
			$this->error('It was not possible to create the new permission.');
	}
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function permission_delete()
	{
		$permission_id = $this->getPermission();
		
		
		$this->UserPermission->bindModel(array(
			'hasMany' => array(
				'UserProfilesUserPermission' => array(
					'className' => 'JjUsers.UserProfilesUserPermission',
				)
			)
		));
		
		$users = $this->UserPermission->UserProfilesUserPermission->find('count', array(
			'conditions' => array('user_permission_id' => $permission_id), 
			'contain' => false
		));
		
		if ($users)
		{
			$this->error('There are permissions joined with profiles. Delete this relations before.');
			return;
		}
		
		if ($this->UserPermission->delete($permission_id))
			$this->out('Permission successfully deleted' . PHP_EOL);
		else
			$this->error('It was not possible to delete the permission.' . PHP_EOL);
	}

/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function getPermission($msg = 'Choose one permission')
	{
		if (isset($this->args[0]))
		{
			$permissions = $this->UserPermission->find('all', array(
				'contain' => false,
				'conditions' => array(
					'slug' => $this->args[0],
				)
			));
			if (count($permissions) == 1)
				return $permissions[0]['UserPermission']['id'];
		}
		
		return false;
	}
	
	
	/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function profile_list()
	{
		$profiles = $this->UserProfile->find('all', array());
		
		$name_length = max(array_map('mb_strlen', Set::extract('/UserProfile/name', $profiles))) + 2;
		$slug_length = max(array_map('mb_strlen', Set::extract('/UserProfile/slug', $profiles))) + 4;
		$description_length = max(array_map('mb_strlen', Set::extract('/UserProfile/description', $profiles))) + 6;
		
		foreach ($profiles as $profile)
		{
			$out = str_pad($profile['UserProfile']['name'], $name_length);
			$out .= str_pad('(' . $profile['UserProfile']['slug'] . ')', $slug_length);
			$out .= str_pad('(' . $profile['UserProfile']['description'] . ')', $description_length);
			$this->out($out);
		}
	}
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function profile_add()
	{
		// Get the name
		$profile['name'] = '';
		if (isset($this->args[0]))
			$profile['name'] = array_shift($this->args);
		while (empty($profile['name']))
			$profile['name'] = $this->in('What is the name for this new profile?');
		
		// Get the slug
		$profile['slug'] = '';
		if (isset($this->args[0]))
			$profile['slug'] = array_shift($this->args);
		do
		{
			while (empty($profile['slug']))
				$profile['slug'] = $this->in('What is the slug for this new profile?', false, strtolower(Inflector::slug($profile['name'])));
			$count = $this->UserProfile->find('count', array(
				'contain' => false, 
				'conditions' => array('slug' => $profile['slug'])
			));
			if ($count)
			{
				$this->out();
				$this->out('There is already one profile with the choosen slug. Choose another one.');
				$profile['slug'] = '';
			}
		} while ($count != 0 || empty($profile['slug']));
		
		
		$this->UserProfile->create(array('UserProfile' => $profile));
		if ($this->UserProfile->save())
			$this->out('Profile \''.$profile['slug'].'\' successfully created');
		else
			$this->error('It was not possible to create the new profile.');
	}
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function profile_delete()
	{
		$profile_id = $this->getProfile();
		
		$this->UserProfile->bindModel(array(
			'hasMany' => array(
				'UserUsersUserProfile' => array(
					'className' => 'JjUsers.UserUsersUserProfile',
				)
			)
		));
		
		$users = $this->UserProfile->UserUsersUserProfile->find('count', array(
			'conditions' => array('user_profile_id' => $profile_id), 
			'contain' => false
		));
		
		if ($users)
		{
			$this->error('The profile is not empty. Before deletion, remove all users from it.');
			return;
		}
		
		if ($this->UserProfile->delete($profile_id))
			$this->out('Profile successfully deleted' . PHP_EOL);
		else
			$this->error('It was not possible to delete the profile.' . PHP_EOL);
	}
	
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function profile_permission()
	{

		$profile_id = $this->getProfile();
		$profile = array_shift($this->args);
		$permission_id = $this->getPermission();
		$permission = array_shift($this->args);
		
		if (!$profile_id) 
			$this->error('It was not possible to found the profile.');
		if (!$permission_id)
			$this->error('It was not possible to found the permission.');
		
		
		$permissions = array();
		$permissions[] = $permission_id;
		if (isset($this->args[0]))
		{
			do
			{
				$permission_id = $this->getPermission();
				$permissions[] = $permission_id;
				$permission = array_shift($this->args);
			} while (isset($this->args[0]));
		}
			
		$data = array(
			'UserProfile' => array('id' => $profile_id),
			'UserPermission' => $permissions
		);
		
		if ($this->UserProfile->saveAll($data))
			$this->out('Permissions successfully added to profile \''.$profile.'\'.');
		else
			$this->error('It was not possible to connect the permission with profile.');
	}
	
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function profile_permission_add()
	{

		$profile_id = $this->getProfile();
		$profile = array_shift($this->args);
		$permission_id = $this->getPermission();
		$permission = array_shift($this->args);
		
		if (!$profile_id) 
			$this->error('It was not possible to found the profile.');
		if (!$permission_id)
			$this->error('It was not possible to found the permission.');
		
		
		$old_permissions = $this->UserProfile->findById($profile_id);
		
		$permissions = array();
		$permissions[] = $permission_id;
		foreach($old_permissions['UserPermission'] as $old_permission)
		{
			$permissions[] = $old_permission['id'];
		}
		
		$data = array(
			'UserProfile' => array('id' => $profile_id),
			'UserPermission' => $permissions
		);
		
		if ($this->UserProfile->saveAll($data))
			$this->out('Permission \''.$permission.'\' successfully added to profile \''.$profile.'\'.');
		else
			$this->error('It was not possible to connect the permission with profile.');
	}
	
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function user_profile_add()
	{

		$user_id = $this->getUser();
		$user = array_shift($this->args);
		$profile_id = $this->getProfile();
		$profile = array_shift($this->args);
		
		if (!$user_id) 
			$this->error('It was not possible to found the user.');
		if (!$profile_id)
			$this->error('It was not possible to found the profile.');
		
		
		$old_profiles = $this->UserUser->findById($user_id);
		
		$profiles = array();
		$profiles[] = $profile_id;
		foreach($old_profiles['UserProfile'] as $old_profile)
		{
			$profiles[] = $old_profile['id'];
		}
		
		$data = array(
			'UserUser' => array('id' => $user_id),
			'UserProfile' => $profiles
		);
		
		if ($this->UserUser->saveAll($data))
			$this->out('Profile \''.$profile.'\' successfully added to user \''.$user.'\'.');
		else
			$this->error('It was not possible to connect the profile with user.');
	}

/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function getProfile($msg = 'Choose one profile')
	{
		if (isset($this->args[0]))
		{
			$profiles = $this->UserProfile->find('all', array(
				'contain' => false,
				'conditions' => array(
					'slug' => $this->args[0],
				)
			));
			if (count($profiles) == 1)
				return $profiles[0]['UserProfile']['id'];
		}
		
		return false;
	}

/**
 * method description
 * 
 * @access public
 * @return type description
 */
	public function getUser($msg = 'Choose one user')
	{
		if (isset($this->args[0]))
		{
			$users = $this->UserUser->find('all', array(
				'contain' => false,
				'conditions' => array(
					'username' => $this->args[0],
				)
			));
			if (count($users) == 1)
				return $users[0]['UserUser']['id'];
		}
		
		return false;
	}
}
