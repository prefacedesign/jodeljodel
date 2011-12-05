<?php
App::import('Config','Tradutore.languages');

class TradLanguageSelectorComponent extends Object
{
	var $components = array('Session');
	var $Controller;
	
	
    function initialize(&$Controller)
    {
		$this->Controller =& $Controller;

		$main_language = Configure::read('Tradutore.mainLanguage');
		$this->Controller->set('mainLanguage', $main_language);

		if (isset($Controller->params['language']))
			$lang = $Controller->params['language'];
		elseif (isset($Controller->params['named']['language']))
			$lang = $Controller->params['named']['language'];
		else
			$lang = '';

		if (!empty($lang))
		{
			$languages = Configure::read('Tradutore.languages');
			if (in_array($lang, $languages))
			{
				$this->setLanguage($lang);
				$this->Session->write('Tradutore.currentLanguage', $lang);
				return true;
			}
		}
		
		if (!$this->Session->check('Tradutore.currentLanguage'))
			$this->Session->write('Tradutore.currentLanguage', $main_language);

		$this->setLanguage($this->Session->read('Tradutore.currentLanguage'));
	}
   
    function setLanguage($lang = null)
    {
        $this->setInterfaceLanguage($lang);
		$this->setModelLanguage($lang);
	
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
