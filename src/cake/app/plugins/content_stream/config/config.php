<?php

/**
 * Here all types of stream content are defined.
 */
Configure::write('ContentStream.streams', array(
	'text' => array(
		'model' => 'Texto',			// Default: tabelize of key
		'plugin' => 'texto',		// Default: key
		'controller' => 'texts',	// Default: pluralize of key
		'titulo' => 'Text'			// Default: Humanize of key
	),
	'image' => array(
		'controller' => 'imagens',
		'model' => 'ImagemFluxo'
	),
	'file' => array(
		'model' => 'ArquivoFluxo'
	)
));

/**
 * Defines all used types of content stream
 * Can only use the streams defined on ContentStream.streams configuration
 *
 * @todo Type validation? Like "can´t publish gallery if number of images is less than X"
 */
Configure::write('ContentStream.types', array(
	'document' => array('text', 'image', 'file'),
	'gallery' => array('image'),
	'folder' => array('file'),
	'article' => array('text', 'image'),
));

/**
 * Configure of some callbacks on content stream editing events
 * Can be "observed" here or on atach the content stream behavior.
 */
Configure::write('ContentStream.callbacks', array(
	'document' => array(
		'create' => array('controller' => 'documents', 'action' => 'created'),
		'update' => array('controller' => 'documents', 'action' => 'updated'),
		'delete' => array('controller' => 'documents', 'action' => 'deleted')
	)
));