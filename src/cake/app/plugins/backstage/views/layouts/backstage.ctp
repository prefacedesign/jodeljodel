<?php
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
		echo $this->Decorator->css(array(
				'plugin' => 'typographer',
				'controller' => 'type_stylesheet',
				'action' => 'style',
				'backstage'
			)
		);
		echo $this->Decorator->css(
			'instant.css',
			'inline'
		);
		
		echo $scripts_for_layout;
	echo $this->Bl->ehead();
	echo $this->Bl->sbody();
		echo $body_content;
	echo $this->Bl->ebody();
echo $this->Bl->ehtml();