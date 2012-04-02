<?php
class UserUsersController extends JjUsersAppController
{
/**
 * Controller name
 * 
 * @access public
 * @var string
 */
	var $name = 'UserUsers';

/**
 * Array of components
 * 
 * @access public
 * @var array
 */
	var $components = array(
		'Burocrata.BuroBurocrata',
		'RequestHandler',
		'Tradutore.TradLanguageSelector',
		'PageSections.SectSectionHandler'
	);

/**
 * Overwrtiging the startupProcess method so we can set (forced) 
 * the language before the pageSections load.
 * 
 * @access public
 */
	function startupProcess()
	{
		$this->TradLanguageSelector->setInterfaceLanguage(Configure::read('Tradutore.mainLanguage'));
		parent::startupProcess();
	}

/**
 * beforeFilter callback, used for overwrite the default messages of AuthComponent
 * 
 * @access public
 * @return void
 */
	function beforeFilter()
	{
		$this->Auth->loginError = __d('backstage', 'Login failed. Invalid username or password.', true);
		$this->Auth->authError = __d('backstage', 'You are not authorized to access that location.', true);
		parent::beforeFilter();
	}

/**
 * Action for user login
 * 
 * @access public
 * @return void
 */
	function login()
	{
		$this->set('typeLayout','login');
		if ($this->Auth->user())
			$this->redirect($this->Auth->loginRedirect);
	}

/**
 * Action for user logout
 * 
 * @access public
 * @return void
 */
	function logout()
	{
		$this->redirect($this->Auth->logout());
	}

/**
 * Action for edit users preferences
 * 
 * @access public
 * @return void
 */
	function preferences()
	{
		if (!empty($this->data)) {
			$error = $this->BuroBurocrata->loadPostedModel($this, $Model);
			
			$this->data[$Model->alias][$Model->primaryKey] = $user_id = $this->Auth->user($Model->primaryKey);
			
			$saved = false;
			$Model->set($this->data);
			if ($Model->validates()) {
				if (!empty($this->data[$Model->alias]['password_change'])) {
					$this->data[$Model->alias]['password'] = $this->Auth->password($this->data[$Model->alias]['password_change']);
				}
				
				if ($Model->save($this->data, false)) {
					$this->UserUser->contain();
					$user = $this->UserUser->findById($user_id);
					$this->Auth->login($user);
					$saved = true;
				}
			}
			
			$this->view = 'JjUtils.Json';
			$this->set(compact('error', 'saved'));
		} else {
			$this->data = $this->Auth->user();
		}
	}
}

