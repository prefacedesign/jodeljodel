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

$body_content = $this->element(
	$layout_scheme.'_layout', 
	array(
		'plugin' => 'typographer',
		'content_for_layout' => $content_for_layout
	)
);

echo $this->Html->doctype();
echo $this->Bl->shtml(array(
		'xmlns' => 'http://www.w3.org/1999/xhtml',
		'xml:lang' => 'pt-br',
		'lang' => 'pt-br'
	)
);

	echo $this->Bl->shead();
		echo $this->Html->charset();
		echo $this->Bl->title(null, null, $title_for_layout);
		echo $this->Bl->link(array(
				'rel' => 'shorcut icon',
				'href' => '/favicon.ico'
			)
		);	
		echo $this->Decorator->css(array('scheme' => 'backstage'));
		echo $this->Decorator->css('instant.css','inline');
		
		echo $scripts_for_layout;
	echo $this->Bl->ehead();
	echo $this->Bl->sbody();
		echo $body_content;
	echo $this->Bl->ebody();
echo $this->Bl->ehtml();
