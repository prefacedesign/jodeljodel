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
 
 
App::import('Vendor','browserdetection');
Configure::load('RequestLog.loggable');


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
 *  - redirected
 *  - is_ajax
 *  - extra_fields (serialized info)
 */
class RequestLoggableComponent extends Object
{

/**
 * List of others components used internally
 * 
 * @access 
 */
	var $components = array('Session', 'RequestHandler', 'PageSections.SectSectionHandler');

/**
 * Holds a reference to the current Controller for internal use
 * 
 * @access protected
 * @var object
 */
	protected $Controller;

/**
 * Holds a reference for the Model of the log database
 * 
 * @access protected
 * @var object
 */
	protected $Model;

/**
 * Temporarily keeps data to be logged until it is not saved
 * 
 * @access protected
 * @var array
 */
	protected $logData;

/**
 * Whether the component will or will not log the current request
 * 
 * @access protected
 * @var boolean
 */
	protected $loggable = false;

/**
 * True if the log has been saved already
 * 
 * @access protected
 * @var boolean
 */
	protected $saved = false;

/**
 * Component initialization using the `startup` callback
 * (right after beforeFilter, but before the action)
 * 
 * @access public
 * @param object $Controller
 * @return void
 */
    function startup(&$Controller)
    {	
		$loggable = (boolean) Configure::read('RequestLog.loggable');
		if ($loggable)
		{
			$logCurrentSection = false;
			$currentSectionContext =& $this->SectSectionHandler->sections;
			
			foreach ($this->SectSectionHandler->ourLocation as $section)
			{
				if (isset($currentSectionContext[$section]))
				{
					if (isset($currentSectionContext[$section]['requestLog']))
						$logCurrentSection = (boolean) $currentSectionContext[$section]['requestLog'];

					if (isset($currentSectionContext[$section]['subSections']))
						$currentSectionContext =& $currentSectionContext[$section]['subSections'];
					else
						break;
				}
			}

			if ($logCurrentSection)
			{
				$this->Controller = $Controller;
				$this->loggable = $loggable;
				$this->Model = ClassRegistry::init('RequestLog.RequestLog');
				$this->setInitialValues();
			}
		}
	}

/**
 * Saves data to database before redirects (because there
 * is no shutdown process after redirect)
 * 
 * @access public
 * @param object $Controller
 * @param string $url
 * @param int $status
 * @param boolean $exit
 * @return void
 */
	public function beforeRedirect($Controller, $url, $status = null, $exit = true)
	{
		if ($exit)
		{
			$this->set('redirected', Router::url($url));
			$this->log();
		}
	}

/**
 * Saves data to database on request shutdown
 * 
 * @access public
 * @param object $Controller
 * @return void
 */
	public function shutdown($Controller)
	{
		$this->log();
	}

/**
 * Sets initial values to $this->logData
 * 
 * @access protected
 * @return void
 */
    protected function setInitialValues()
	{
		if (!$this->loggable)
		{
			return;
		}

		$parameters = $this->Controller->params;

		$params = '';
		if (!empty($parameters['pass']))
			$params = join('/', $parameters['pass']) . '/';

		foreach ($parameters['named'] as $key => $param)
			$params .= $key . ':' . $param . '/';

		$data = $this->maskData($this->Controller->data);
		$browserInfo = getBrowser() + array('userAgent' => '', 'name' => '', 'version' => '', 'platform' => '');

		$new_data = array(
			'time' => date("Y-m-d h:i:s"),
			'session_id' => $this->Session->id(),
			'ip' => $this->RequestHandler->getClientIP(),
			'is_ajax' => $this->RequestHandler->isAjax(),
			'url' => $this->Controller->here,
			'user_agent' => $browserInfo['userAgent'],
			'browser_name' => $browserInfo['name'],
			'browser_version' => $browserInfo['version'],
			'os' => $browserInfo['platform'],
			'plugin' => $parameters['plugin'],
			'controller' => $parameters['controller'],
			'action' => $parameters['action'],
			'params' => $params,
			'method' => $_SERVER['REQUEST_METHOD'],
			'post' => substr(serialize($data), 0, 7300),
		);

		foreach ($new_data as $key => $content)
		{
			$this->set($key, $content);
		}
	}

/**
 * Applies mask over sensitive data, using the configuration parameters
 *
 * Empty values are left empty but I dont know if this is really a good ideia
 * 
 * @access protected
 * @param array $data The array of data to lookup sensitive data
 * @return array The data with sensitive data erased
 */
	protected function maskData($data)
	{
		foreach (Configure::read('RequestLog.maskFields') as $field)
		{
			list($modelName, $fieldName) = explode('.', $field);
			if (!empty($data[$modelName][$fieldName]))
				$data[$modelName][$fieldName] = '[MASKED]';
		}
		return $data;
	}
	
/**
 * Set one value to $this->logData
 * 
 * @access public
 * @return void
 */
    public function set($key, $value)
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
			$this->logData[$this->Model->alias][$key] = $value;
		}
		else
		{
			if (empty($this->logData[$this->Model->alias]['extra_fields']))
				$this->logData[$this->Model->alias]['extra_fields'] = array();

			$this->logData[$this->Model->alias]['extra_fields'][$key] = $value;
		}
	}

/**
 * Saves the log data previously stored into $this->logData
 * 
 * @access public
 * @return boolean True if data was saved, false if was not
 */
	public function log()
	{
		if (!$this->loggable || $this->saved)
		{
			return false;
		}

		$this->saved = true;
		if (!empty($this->logData[$this->Model->alias]['extra_fields']))
			$this->logData[$this->Model->alias]['extra_fields'] = serialize($this->logData[$this->Model->alias]['extra_fields']);

		$this->Model->create($this->logData);
		return $this->Model->save();
	}
}
