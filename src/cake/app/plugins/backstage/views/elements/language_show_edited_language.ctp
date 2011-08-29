<?php
	$linkList = array();
	foreach($translatedLanguages as $lang)
	{
		$lang = 'Language name: '.$lang;
		$linkList[] = array(
			'name' => __('backstage', $lang, true),
			'url' => am(array('language' => $lang), $this->params['pass'])
		);
	}
	$tmp = $this->Bl->anchorList(array(),array('lastSeparator' => __('anchorList and', true), 'linkList' => $linkList));	
	
	echo $this->Bl->p(array('class' => 'small_text'), array('escape' => false),
		sprintf (__('backstage','This content already has translations for %s.',true), $tmp));
	echo $this->Bl->brDry();
		
	$missingLanguages =	array_diff(Configure::read('Tradutore.languages'), $translatedLanguages);
	
	if (!empty($missingLanguages))
	{
		$linkList = array();
		foreach($missingLanguages as $lang)
		{
			$lang = 'Language name: '.$lang;
			$linkList[] = array(
				'name' => __d('backstage', $lang, true),
				'url' => am(array('language' => $lang), $this->params['pass'])
			);
		}
		echo $this->Bl->p(
			array('class' => 'small_text'), 
			array('escape' => false),
			sprintf (
				__('backstage','If you want you can create a version for %s',true),
				$this->Bl->anchorList(array(),array('lastSeparator' => __('anchorList or', true), 'linkList' => $linkList))
			)
		);
	}