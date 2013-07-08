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
	),
	'pie_entity' => array(
		'model' => 'PieEntity.PieEntity',
		'title' => __d('content_stream', 'Title for PieEntity content', true)
	),
));

/**
 * Defines all used types of content stream
 * Can only use the streams defined on ContentStream.streams configuration
 *
 * @todo Type validation? Like "can´t publish gallery if number of images is less than X"
 */
Configure::write('ContentStream.types', array(
	'document' => array('pie_text', 'pie_image', 'pie_file', 'pie_divider', 'pie_title', 'pie_entity'),
	'gallery' => array('pie_image'),
	'folder' => array('pie_file'),
	'article' => array('pie_text', 'pie_image'),
	'cork' => array('pie_text', 'pie_image', 'pie_title', 'pie_divider'),
));
