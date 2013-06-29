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

/**
 * Model used for saving log data on database
 * 
 */
class RequestLog extends RequestLogAppModel
{

/**
 * CakePHP demand for PHP 4
 * 
 * @access public
 */
	var $name = 'RequestLog';

/**
 * A separated DB Config for logging on another database (or another server)
 * 
 * @access public
 * @var string
 */
	var $useDbConfig = 'request_log';

}
