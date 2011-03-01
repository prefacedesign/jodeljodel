<?php
App::import('Config','Tradutore.languages');

class TradLanguageSelectorComponent extends Object
{
	var $components = array('Session');
	var $controller;
	
	
    function initialize(&$controller)
    {
		$this->controller =& $controller;
	
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
        $this->setInterfaceLanguage($lang);
		$this->setModelLanguage($lang);
	
		$this->controller->set('currentLanguage', $lang);
	}
	
	function setInterfaceLanguage($lang = null)
    {
        Configure::write('Config.language', $lang);
		
		$this->controller->set('currentInterfaceLanguage', $lang);
	}
	
	
	function setModelLanguage($lang = null)
    {
		App::import('Behavior','Tradutore.TradTradutore');
        TradTradutoreBehavior::setGlobalLanguage($lang);
		
		$this->controller->set('currentModelLanguage', $lang);
	}
}
?>