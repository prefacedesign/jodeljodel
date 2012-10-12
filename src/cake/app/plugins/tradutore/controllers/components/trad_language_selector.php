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

App::import('Config','Tradutore.languages');

class TradLanguageSelectorComponent extends Object
{
	var $components = array('Session', 'Cookie');
	var $Controller;
	
	static $_countryLanguage = array(
		'Angola' => 'por',
		'Brazil' => 'por',
		'Portugal' => 'por',
		'Sao Tome and Principe' => 'por',
		'Mozambique' => 'por',
	);
	
/**
 * Component initialization
 * 
 * @access public
 * @return void
 */
    function initialize(&$Controller)
    {
    	$this->Cookie->time = '1 year';
		$this->Cookie->name = 'tradutore';
		$this->Cookie->key = 'tradutoreKeyForCrypt';
		
		$this->Controller =& $Controller;
		
		$mainLanguage = Configure::read('Tradutore.mainLanguage');
		$this->Controller->set(compact('mainLanguage'));
		
		$lang = '';
		if (count(Configure::read('Tradutore.languages')) > 1)
		{
			// tries to get the language from the URL
			$lang = $this->getURLLanguage();
			
			if (!$this->isValidLanguage($lang))
			{
				// tries to get the language from previous set Cookie
				$lang = $this->Cookie->read('lang');
				
				if (!$this->isValidLanguage($lang))
				{
					// tries to guess the language using the configured method
					$lang = $this->guessLanguage();
				}
			}
		
		}
		
		if (!$this->isValidLanguage($lang))
			$lang = $mainLanguage;
		
		$this->setLanguage($lang);
	}

/**
 * Checks if the language is valid (is in use)
 * 
 * @access public
 * @param string $lang
 * @return boolean True, if it is one valid language
 */
	function isValidLanguage($lang)
	{
		return in_array($lang, Configure::read('Tradutore.languages'));
	}

/**
 * Tries to recover the current language from passed parameters (via URL)
 * 
 * @access public
 * @return string The language
 */
	function getURLLanguage()
	{
		$lang = '';
		if (isset($this->Controller->params['language']))
			$lang = $this->Controller->params['language'];
		elseif (isset($this->Controller->params['named']['language']))
			$lang = $this->Controller->params['named']['language'];
		return $lang;
	}

/**
 * Tries to guess the user preferred language.
 * 
 * @access public
 * @return string The language guess, or an empty string when the guessing was not possible
 */
	function guessLanguage()
	{
		$guess = '';
		switch (Configure::read('Tradutore.guessingMethod'))
		{
			case 'http':
				$I18n =& I18n::getInstance();
				$I18n->l10n->get();
				$guess = $I18n->l10n->catalog($I18n->l10n->lang);
				$guess = $guess['localeFallback'];
			break;
		
			case 'ip':
				App::import('Vendor', 'Tradutore.Net_GeoIP', array('file' => 'geoip'.DS.'Net'.DS.'GeoIP.php'));
				$databaseFile = dirname(dirname(dirname(__FILE__))) . DS . 'vendors' . DS . 'geoip' . DS . 'data' . DS . 'GeoIP.dat';
				$geoip = Net_GeoIP::getInstance($databaseFile, Net_GeoIP::STANDARD);
				$country = $geoip->lookupCountryName($this->getClientIP());
				
				if (isset(self::$_countryLanguage[$country]))
					$guess = self::$_countryLanguage[$country];
				else
					$guess = Configure::read('Tradutore.guessingFallback');
			break;
		}

		return $guess;
	}

/**
 * Tries to get the client IP using the HTTP data
 * 
 * @access public
 * @return string|false the IP address when found. False otherwise
 */
	protected function getClientIP()
	{
		if (($ip = getenv("HTTP_CLIENT_IP")) && $this->isLocalIp($ip) === false)
			return $ip;
		elseif (($ip = getenv("HTTP_X_FORWARDED_FOR")) && $this->isLocalIp($ip) === false)
			return $ip;
		else 
			return getenv("REMOTE_ADDR");

		return false;
	}
/**
 * Check if it is an ip from local network
 * 
 * @access protected
 * @return boolean True, if it is an ip from local network
 */
	protected function isLocalIp($ip)
	{
		$intIP = ip2long($ip);
		if ($intIP === false || $intIP < 0)
			return null;
		
		return
			   $intIP >= 167772160  && $intIP <= 184549375   // 10.0.0.0 - 10.255.255.255
			|| $intIP >= 2886729728 && $intIP <= 2887778303  // 172.16.0.0 - 172.31.255.255
			|| $intIP >= 3232235520 && $intIP <= 3232301055; // 192.168.0.0 - 192.168.255.255
	}

/**
 * Sends the current language all over the application
 * Also, it writes the language to cookie to use it in latter requests
 * 
 * @access public
 * @param string $lang
 * @return void
 */
    function setLanguage($lang = null)
    {
        $this->setInterfaceLanguage($lang);
		$this->setModelLanguage($lang);
	
		$this->Cookie->write('lang', $lang);
		$this->Session->write('Tradutore.currentLanguage', $lang);
		$this->Controller->set('currentLanguage', $lang);
	}


	function setInterfaceLanguage($lang = null)
    {
    	if (!Configure::read('Tradutore.currentInterfaceLanguage'))
    	{
		    Configure::write('Config.language', $lang);
			Configure::write('Tradutore.currentInterfaceLanguage', $lang);
#			$this->Controller->set('currentInterfaceLanguage', $lang);
    	}
	}


	function setModelLanguage($lang = null)
    {
		App::import('Behavior','Tradutore.TradTradutore');
        TradTradutoreBehavior::setGlobalLanguage($lang);
		
		$this->Controller->set('currentModelLanguage', $lang);
	}
}
?>
