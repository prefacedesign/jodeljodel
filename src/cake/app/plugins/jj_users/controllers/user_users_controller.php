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
		'PageSections.SectSectionHandler',
		'Session'
	);

/**
 * List of models
 * 
 * @access public
 * @var array
 */
	var $uses = array('JjUsers.UserUser', 'JjUsers.UserProfile');

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
 * Action for user login
 * 
 * @access public
 * @return void
 */
	function login()
	{
		$this->set('typeLayout','login');
		if ($this->JjAuth->user())
			$this->redirect($this->JjAuth->loginRedirect);
	}

/**
 * Action for user logout
 * 
 * @access public
 * @return void
 */
	function logout()
	{
		$this->redirect($this->JjAuth->logout());
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
			
			$this->data[$Model->alias][$Model->primaryKey] = $user_id = $this->JjAuth->user($Model->primaryKey);
			
			$saved = false;
			$Model->set($this->data);
			if ($Model->validates()) {
				if (!empty($this->data[$Model->alias]['password_change'])) {
					$this->data[$Model->alias]['password'] = $this->JjAuth->password($this->data[$Model->alias]['password_change']);
				}
				
				if ($Model->save($this->data, false)) {
					$this->UserUser->contain();
					$user = $this->UserUser->findById($user_id);
					$this->JjAuth->login($user);
					$saved = true;
				}
			}
			
			$this->view = 'JjUtils.Json';
			$this->set(compact('error', 'saved'));
		} else {
			$this->data = $this->JjAuth->user();
		}
	}
}

