<?php
/**
 * @todo Maybe we should review the renderLayout in the view, in order
 *	  to not need to place this odd layout. We should indeed create the concept
 *	  of subLayouts to make it work nicely.
 */

// We need to proccess the body before we create the header,
// because in the header we add the missing CSS rules, that were not created 
// in the CSS style file.
$dentro_body = $this->element(
	$modelo_de_layout.'_layout', 
	array(
		'plugin' => 'estilista',
		'content_for_layout' => $content_for_layout
	)
);

echo $html->doctype();
echo $h->iHtml(array(
		'xmlns' => 'http://www.w3.org/1999/xhtml',
		'xml:lang' => 'pt-br',
		'lang' => 'pt-br'
	)
);

	echo $h->iHead();
		echo $html->charset();
		echo $h->title(null, null, $title_for_layout);
		echo $h->link(array(
				'rel' => 'shorcut icon',
				'href' => '/favicon.ico'
			)
		);	
		echo $pintor->css(array(
				'plugin' => 'estilista',
				'controller' => 'estilos',
				'action' => 'estilo',
				'teste'
			)
		);
		echo $pintor->css(
			'estilo_instantaneo.css',
			'inline'
		);
		
		echo $scripts_for_layout;			
	echo $h->fHead();
	echo $h->iBody();
		echo $dentro_body;
	echo $h->fBody();
echo $h->fHtml();