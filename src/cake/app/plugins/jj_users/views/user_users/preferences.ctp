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


if (isset($error))
{
	$object = compact('error', 'saved');
	$object['content'] = null;
	
	if (!$error)
	{
		$object['content'] = $this->Buro->insertForm('JjUsers.UserUser', array('preferences'));
	}
	
	echo $this->Js->object($object);
}
else
{
	echo $this->Bl->sbox(array(),array('size' => array('M' => 12, 'g' => -1)));
		echo $this->Bl->h1Dry($sectionInfo['humanName']);
	echo $this->Bl->ebox();

	echo $this->Bl->sbox(array(),array('size' => array('M' => 7, 'g' => -1)));
		echo $this->Buro->insertForm('JjUsers.UserUser', array('preferences'));
	echo $this->Bl->ebox();

	echo $this->Popup->popup('error',
		array(
			'type' => 'error',
			'title' => __d('backstage','Your data cannot be saved - TITLE.',true),
			'content' => __d('backstage', 'Your data cannot be saved - TEXT.', true)
		)
	);

	echo $this->Popup->popup('notice',
		array(
			'type' => 'notice',
			'title' => __d('backstage', 'Your data has been saved - TITLE.',true),
			'content' => __d('backstage', 'Your data has been saved - TEXT.',true),
		)
	);
}


