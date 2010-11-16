<?php
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
		echo $typeDecorator->css(array(
				'plugin' => 'typographer',
				'controller' => 'type_stylesheet_controller',
				'action' => 'style',
				'teste'
			)
		);
		echo $typeDecorator->css(
			'instant.css',
			'inline'
		);
		
		echo $scripts_for_layout;			
	echo $h->ehead();
	echo $h->ebody();
		echo $body_content;
	echo $h->ebody();
echo $h->ehtml();