<?php
App::import('Config','Tradutore.languages');

class TradLanguageSelectorComponent extends Object
{
	var $components = array('Session');
	
	
    function startup(&$controller)
    {
		if (isset($controller->params['language']))
			$lang = $controller->params['language'];
		else
			$lang = '';
		//debug($lang);
		if (!empty($lang))
		{
			
			$languages = Configure::read('Tradutore.languages');
			//debug($languages);
			if (in_array($lang, $languages)) {
				$this->setLanguage($lang);
				//debug($lang);
				$this->Session->write('Tradutore.currentLanguage', $lang);
				return true;
			}
		}
		if (!$this->Session->check('Tradutore.currentLanguage'))
		{
			$main_language = Configure::read('Tradutore.mainLanguage');
			$this->setLanguage($main_language);
			$this->Session->write('Tradutore.currentLanguage', $main_language);
		}
		else
			$this->setLanguage($this->Session->read('Tradutore.currentLanguage'));
		
	}
   
    function setLanguage($lang = null)
    {
		//debug($lang);
        $this->setInterfaceLanguage($lang);
		$this->setModelLanguage($lang);
	}
	
	function setInterfaceLanguage($lang = null)
    {
		//debug('teste');
		//debug($lang);
        Configure::write('Config.language', $lang);
	}
	
	
	function setModelLanguage($lang = null)
    {
		App::import('Behavior','Tradutore.TradTradutore');
        TradTradutoreBehavior::setGlobalLanguage($lang);
		//debug($lang);
	}
}
?>