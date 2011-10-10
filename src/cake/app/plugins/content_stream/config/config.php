<?php

/**
 * Here all types of stream content are defined.
 * 
 * ### Options availables are:
 * - `model` string - Model´s fullname (including plugin) (defults to Camelize.Classify of key)
 * - `title` string - The name that will be used on interface to indentify this stream (Defaults to Humanize of key)
 * 
 * All options are optional and must be indexed by a indentifier key (that will be used on next config).
 * If no option are given, it is possible to list just the key.
 */
Configure::write('ContentStream.streams', array(
	'pie_image' => array(
		'model' => 'PieImage.PieImage',
		'title' => __d('content_stream', 'Title for PieImage content', true)
	),
	'pie_file' => array(
		'model' => 'PieFile.PieFile',
		'title' => __d('content_stream', 'Title for PieFile content', true)
	),
	'pie_text' => array(
		'model' => 'PieText.PieText',
		'title' => __d('content_stream', 'Title for PieText content', true)
	),
	'pie_divider' => array(
		'model' => 'PieDivider.PieDivider',
		'title' => __d('content_stream', 'Title for PieDivider content', true)
	),
	'pie_title' => array(
		'model' => 'PieTitle.PieTitle',
		'title' => __d('content_stream', 'Title for PieTitle content', true)
	)
));

/**
 * Defines all used types of content stream
 * Can only use the streams defined on ContentStream.streams configuration
 *
 * @todo Type validation? Like "can´t publish gallery if number of images is less than X"
 */
Configure::write('ContentStream.types', array(
	'document' => array('pie_text', 'pie_image', 'pie_file', 'pie_divider', 'pie_title'),
	'gallery' => array('pie_image'),
	'folder' => array('pie_file'),
	'article' => array('pie_text', 'pie_image'),
	'cork' => array('pie_text', 'pie_image', 'pie_title', 'pie_divider'),
));