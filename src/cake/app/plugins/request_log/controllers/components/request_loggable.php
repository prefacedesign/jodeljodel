<?php
/**
 * RequestLoggable Component
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author Rodrigo Caravita, Lucas Vignoli
 * @version 1.1
 * created 30. september 2012
 * last modified 20. april 2013
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 *
 *
 */
 
/**
 * This component saves all system activity into a log
 * 
 * 
 * Usage example :
 * 
 * In AppController::beforeFilter, you should call:
 * $this->RequestLoggable->log();
 * 
 * Any other field can be settled by:
 * $this->RequestLoggable->set($key, $value);
 * in this case, the field will be save serialized in extra_fields database field
 * This function should be called before log():
 * 
 * All data is saved into post field in database
 *
 *
 * Default fields logged:
 *  - time
 *  - user_id (JjUser id)
 *  - session_id (CakePHP session_id)
 *  - ip
 *  - user_agent
 *  - browser_name
 *  - browser_version
 *  - os
 *  - url
 *  - plugin 
 *  - controller
 *  - action
 *  - params
 *  - method
 *  - post (serialized info)
 *  - extra_fields (serialized info)
 */
 
App::import('Vendor','browserdetection');
App::import('Config','RequestLog.loggable');

class RequestLoggableComponent extends Object
{
	var $Controller;
	var $Model;
	var $loggable = true;
	var $what_to_log = array();
	
	private static $data;
	
/**
 * Component initialization
 * 
 * @access public
 * @return void
 */
	
    function initialize(&$Controller)
    {	
		$this->loggable = Configure::read('RequestLog.loggable');
		$this->what_to_log = Configure::read('RequestLog.what_to_log');
		
		if ($this->loggable)
		{
			$this->Controller = $Controller;
			$this->Model = ClassRegistry::init('RequestLog.RequestLog');
			$this->setValues();
		}
	}

/**
 * Set initial values to self::data
 * 
 * @access private
 * @return void
 */
    private function setValues()
	{
		if (!$this->loggable)
		{
			return;
		}
			
		$data = $this->Controller->data;
		$parameters = $this->Controller->params;
		
		$this->Controller->Session->start();
		$this->Controller->Session->id(session_id());
		
		$params = '';
		$session_id = '';
		
		if ($this->Controller->Session->id)
			$session_id = $this->Controller->Session->id;
		
		foreach($parameters['pass'] as $param)
		{
			$params .= $param . '/';
		}
		foreach($parameters['named'] as $key => $param)
		{
			$params .= $key . ':' . $param . '/';
		}
		
		if (isset($data['UserUser']['password']) && !empty($data['UserUser']['password']))
		{
			$data['UserUser']['password'] = '********';
		}
		if (isset($data['UserUser']['password_change']) && !empty($data['UserUser']['password_change']))
		{
			$data['UserUser']['password_change'] = '********';
		}
		if (isset($data['UserUser']['password_retype']) && !empty($data['UserUser']['password_retype']))
		{
			$data['UserUser']['password_retype'] = '********';
		}
		
		$browser = array('userAgent' => '', 'name' => '', 'version' => '', 'platform' => '');
		$browserInfo = am($browser, getBrowser());
		$client_ip = RequestHandlerComponent::getClientIP();
		$url = isset($parameters['url']['url']) ? $parameters['url']['url'] : '';
		$new_data = array($this->Model->alias => array(
			'time' => date("Y-m-d h:i:s"),
			'session_id' => $session_id,
			'ip' => $client_ip,
			'user_agent' => $browserInfo['userAgent'],
			'browser_name' => $browserInfo['name'],
			'browser_version' => $browserInfo['version'],
			'os' => $browserInfo['platform'],
			'url' => $url,
			'plugin' => $parameters['plugin'],
			'controller' => $parameters['controller'],
			'action' => $parameters['action'],
			'params' => $params,
			'method' => $_SERVER['REQUEST_METHOD'],
			'post' => substr(serialize($data), 0, 7300),
		));
		
		foreach($this->Model->_schema as $key => $props)
		{
			if ($key != 'id')
			{
				if (empty(self::$data[$this->Model->alias][$key]) && isset($new_data[$this->Model->alias][$key]))
				{
					$this->set($key, $new_data[$this->Model->alias][$key]);
				}
			}
		}
	}
	
/**
 * Set one value to self::data
 * 
 * @access public
 * @return void
 */
    function set($key, $value)
	{
		if (!$this->loggable)
		{
			return;
		}

		if ($key == 'post' && is_array($value))
		{
			$value = serialize($value);
		}
		
		if (isset($this->Model->_schema[$key]))
		{
			self::$data[$this->Model->alias][$key] = $value;
		}
		else
		{
			if (isset(self::$data[$this->Model->alias]['extra_fields']))
			{
				$data = unserialize(self::$data[$this->Model->alias]['extra_fields']);
				$data[$key] = $value;
			}
			else
			{
				$data = array($key => $value);
			}
			self::$data[$this->Model->alias]['extra_fields'] = serialize($data);
		}
	}

/**
 * Logs information previously saved into self::data
 * 
 * @access public
 * @return true if register is logged, false if not
 */
	function log()
	{
		if ($this->loggable)
		{
			if ((self::$data[$this->Model->alias]['plugin'] == 'dashboard' ||
				self::$data[$this->Model->alias]['plugin'] == 'backstage' ||
				(self::$data[$this->Model->alias]['plugin'] == 'burocrata' && 
				self::$data[$this->Model->alias]['method'] == 'POST')) &&
				!in_array('admin', $this->what_to_log))
			{
				
				return false;
			}
			elseif (self::$data[$this->Model->alias]['plugin'] == 'jj_media' &&
				self::$data[$this->Model->alias]['method'] == 'POST' &&
				!in_array('admin', $this->what_to_log))
			{
				$post = unserialize(self::$data[$this->Model->alias]['post']);
				if (isset($post['_b']['layout_scheme']) && $post['_b']['layout_scheme'] == 'backstage')
				{
					return false;
				}
			}
			elseif (self::$data[$this->Model->alias]['plugin'] == 'typographer' &&
				!in_array('css', $this->what_to_log))
			{
				return false;
			}
			elseif (self::$data[$this->Model->alias]['plugin'] == 'jj_media' &&
				self::$data[$this->Model->alias]['method'] == 'GET' &&
				!in_array('media', $this->what_to_log))
			{
				return false;
			}
			elseif ((self::$data[$this->Model->alias]['plugin'] != 'jj_media' &&
				self::$data[$this->Model->alias]['plugin'] != 'backstage' &&
				self::$data[$this->Model->alias]['plugin'] != 'dashboard' &&
				self::$data[$this->Model->alias]['plugin'] != 'burocrata') &&
				!in_array('public', $this->what_to_log))
			{
				return false;
			}
			
			return $this->Model->save(self::$data);
		}
		
		return false;
	}
}
?>
