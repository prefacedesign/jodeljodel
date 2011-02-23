<?php
App::import('Config','Tradutore.languages');

class TradLanguageSelectorComponent extends Object
{
    function startup(&$controller)
    {
		if (isset($controller->params['language']))
			$lang = $controller->params['language'];
		else
			$lang = '';
		//debug($lang);
		if ($lang) 
		{
			$languages = Configure::read('Tradutore.languages');
			if (in_array($lang, $languages)) {
				$this->setLanguage($lang);
			}
			else
			{
				$main_language = Configure::read('Tradutore.mainLanguage');
				$this->setLanguage($main_language);
			}
		}
		else
		{
			$main_language = Configure::read('Tradutore.mainLanguage');
			$this->setLanguage($main_language);
		}
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
	}
}
?>