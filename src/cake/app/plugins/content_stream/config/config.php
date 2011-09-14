<?php

/**
 * Here all types of stream content are defined.
 * 
 * ### Options availables are:
 * - `model` string - Model´s fullname (including plugin) (defults to 'TheKey.TheKey')
 * - `title` string - The name that will be used on interface to indentify this stream (Defaults to 'The Key')
 * 
 * All options are optional and must be indexed by a indentifier key (that will be used on next config).
 * If no option are given, it is possible to list just the key.
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