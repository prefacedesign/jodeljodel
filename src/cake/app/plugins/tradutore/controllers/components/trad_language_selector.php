<?php
App::import('Config','Tradutore.languages');

class TradLanguageSelectorComponent extends Object
{
	var $components = array('Session', 'Cookie');
	var $Controller;
	
	static $_coutryLanguage = array(
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
			$lang = $this->getURLLanguage();
			if (empty($lang))
			{
				$lang = $this->guessLanguage();
				if ($lang)
					$this->Controller->redirect(array('language' => $lang));
			}
		}
		
		if (!$this->isValidLanguage($lang))
			$this->Controller->redirect(array('language' => $mainLanguage));
		
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
 * @return string The language guess
 */
	function guessLanguage()
	{
		$auto = $this->Cookie->read('lang');
		if (empty($auto))
		{
			switch (Configure::read('Tradutore.guessingMethod'))
			{
				case 'http':
					$I18n =& I18n::getInstance();
					$I18n->l10n->get();
					$auto = $I18n->l10n->catalog($I18n->l10n->lang);
					$auto = $auto['localeFallback'];
				break;
			
				case 'ip':
					App::import('Vendor', 'Tradutore.Net_GeoIP', array('file' => 'geoip'.DS.'Net'.DS.'GeoIP.php'));
					$databaseFile = dirname(dirname(dirname(__FILE__))) . DS . 'vendors' . DS . 'geoip' . DS . 'data' . DS . 'GeoIP.dat';
					$geoip = Net_GeoIP::getInstance($databaseFile, Net_GeoIP::STANDARD);
					$country = $geoip->lookupCountryName($this->getClientIP());
					
					if (isset(self::$_coutryLanguage[$country]))
						$auto = self::$_coutryLanguage[$country];
				break;
			}
			if (!$this->isValidLanguage($auto))
				$auto = Configure::read('Tradutore.mainLanguage');
		}
		return $auto;
	}
/**
 * method description
 * 
 * @access public
 * @return type description
 */
	protected function getClientIP()
	{
		return '187.106.36.4';
		if (getenv("HTTP_CLIENT_IP"))
			return getenv("HTTP_CLIENT_IP");
		elseif (getenv("HTTP_X_FORWARDED_FOR"))
			return getenv("HTTP_X_FORWARDED_FOR");
		else 
			return getenv("REMOTE_ADDR"); 
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
        Configure::write('Config.language', $lang);
		
		$this->Controller->set('currentInterfaceLanguage', $lang);
	}
	
	
	function setModelLanguage($lang = null)
    {
		App::import('Behavior','Tradutore.TradTradutore');
        TradTradutoreBehavior::setGlobalLanguage($lang);
		
		$this->Controller->set('currentModelLanguage', $lang);
	}
}
?>
