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

/**
 * @todo Maybe we should review the renderLayout in the view, in order
 *	  to not need to place this odd layout. We should indeed create the concept
 *	  of subLayouts to make it work nicely.
 */

// We need to proccess the body before we create the header,
// because in the header we add the missing CSS rules, that were not created 
// in the CSS style file.

// @todo Maybe we should use the View to have this always.

$body_content = $this->element(
	$layout_scheme.'_layout', 
	array(
		'plugin' => 'typographer',
		'content_for_layout' => $content_for_layout
	)
);

echo $html->doctype();
echo $bl->shtml(array(
		'xmlns' => 'http://www.w3.org/1999/xhtml',
		'xml:lang' => 'pt-br',
		'lang' => 'pt-br'
	)
);

	echo $bl->shead();
		echo $html->charset();
		echo $bl->title(null, null, $title_for_layout);
		echo $bl->link(array(
				'rel' => 'shorcut icon',
				'href' => '/favicon.ico'
			)
		);	
		echo $decorator->css(array(
				'plugin' => 'typographer',
				'controller' => 'type_stylesheet',
				'action' => 'style',
				'teste'
			)
		);
		echo $decorator->css(
			'instant.css',
			'inline'
		);
		
		echo $scripts_for_layout;			
	echo $bl->ehead();
	echo $bl->ebody();
		echo $body_content;
	echo $bl->ebody();
echo $bl->ehtml();