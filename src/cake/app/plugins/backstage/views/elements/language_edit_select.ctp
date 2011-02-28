<?php
	$linkList = array();
	foreach($translatedLanguages as $lang)
	{
		$linkList[] = array('name' => __('Language name: '.$lang, true), 'url' => Router::url(am(array('language' => $lang), $this->params['pass'])));
	}
	$tmp = $this->Bl->anchorList(array(),array('lastSeparator' => __('anchorList and', true), 'linkList' => $linkList));	
	
	echo $this->Bl->p(array('class' => 'small_text'), array('escape' => false),
		sprintf (__('This content already has translations for %s.',true), $tmp));
		
	echo $this->Bl->brDry();
		
	$missingLanguages =	array_diff(Configure::read('Tradutore.languages'), $translatedLanguages);
	
	if (!empty($missingLanguages))
	{
		$linkList = array();
		foreach($missingLanguages as $lang)
		{
			$linkList[] = array('name' => __('Language name: '.$lang, true), 'url' => Router::url(am(array('language' => $lang), $this->params['pass'])));
		}
		echo $this->Bl->p(
			array('class' => 'small_text'), 
			array('escape' => false),
			sprintf (
				__('Backstage edit page: If you want you can create a version for %s',true),
				$this->Bl->anchorList(array(),array('lastSeparator' => __('anchorList or', true), 'linkList' => $linkList))
			)
		);
	}