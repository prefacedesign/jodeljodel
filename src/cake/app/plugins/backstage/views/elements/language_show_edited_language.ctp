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

	$linkList = array();
	foreach($translatedLanguages as $lang)
	{
		$lang = 'Language name: '.$lang;
		$linkList[] = array(
			'name' => __d('backstage', $lang, true),
			'url' => am(array('language' => $lang), $this->params['pass'])
		);
	}
	$tmp = $this->Bl->anchorList(array(),array('lastSeparator' => __('anchorList and', true), 'linkList' => $linkList));	
	
	echo $this->Bl->p(array('class' => 'small_text'), array('escape' => false),
		sprintf (__d('backstage','This content already has translations for %s.',true), $tmp));
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
				__d('backstage','If you want you can create a version for %s',true),
				$this->Bl->anchorList(array(),array('lastSeparator' => __('anchorList or', true), 'linkList' => $linkList))
			)
		);
	}