<?php

/**
 * Here all types of stream content are defined.
 */
Configure::write('ContentStream.streams', array(
	'cs_image','cs_file',
	'cs_text' => array(
		'model' => 'CsText.CsText',	// Default: "CsText.CsText" (Camelize.Classify of key)
		'controller' => 'texts',	// Default: "CsTexts" (Pluralize of key)
		'title' => 'Text'			// Default: "Cs Text" (Humanize of key)
	)
));

/**
 * Defines all used types of content stream
 * Can only use the streams defined on ContentStream.streams configuration
 *
 * @todo Type validation? Like "can´t publish gallery if number of images is less than X"
 */
Configure::write('ContentStream.types', array(
	'document' => array('cs_text', 'cs_image', 'cs_file'),
	'gallery' => array('cs_image'),
	'folder' => array('cs_file'),
	'article' => array('cs_text', 'cs_image'),
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