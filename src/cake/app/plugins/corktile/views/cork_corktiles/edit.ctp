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

echo $this->Bl->sbox(array(), array('size'=> array('M' => 12, 'g' => -1)));
	echo $this->Bl->h1Dry(__d('corktile', 'Corktile edit page: Editing a fixed content', true));
	echo $this->Bl->sbigInfoBox();
		echo $this->element('location_of_cork', array('plugin' => 'corktile'));
	echo $this->Bl->ebigInfoBox();
echo $this->Bl->ebox();

echo $this->Bl->sbox(array(),array('size' => array('M' => 7, 'g' => -1)));
	if (isset($this->data[$this->data['ModuleInfo']['model']]['languages']))
	{
		echo $this->element('language_edit_select', array('plugin' => 'backstage', 'can_create' => true, 'translatedLanguages' => $this->data[$this->data['ModuleInfo']['model']]['languages']));
		echo $this->element('show_language_being_edited',array('plugin' => 'backstage'));
	}	
	
	
	echo $this->Popup->popup('error',
		array(
			'type' => 'error',
			'title' => __d('corktile', 'Corktile edit page: Your data cannot be saved - TITLE.',true),
			'content' => __d('corktile', 'Corktile edit page: Your data cannot be saved - TEXT.', true)
		)
	);
	$url = Router::url(array('plugin' => 'dashboard', 'controller' => 'dash_dashboard', 'action' => 'index'));
	echo $this->Popup->popup('notice',
		array(
			'type' => 'notice',
			'title' => __d('corktile', 'Corktile edit page: Your data has been saved - TITLE.',true),
			'content' => __d('corktile', 'Corktile edit page: Your data has been saved - TEXT.',true),
			'actions' => array('ok' => 'ok', 'edit' => __d('backstage', 'Your data has been saved - CONTINUE EDITING', true)),
			'callback' => "if (action=='ok') window.location = '$url'"
		)
	);
	
	echo $buro->insertForm($fullModelName, array('cork'));
echo $this->Bl->ebox();
