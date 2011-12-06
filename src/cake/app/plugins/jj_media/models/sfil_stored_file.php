<?php
/**
 * Copyright 2010-2011, Preface Design
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010-2011, Preface Design
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Media enhanced plugin
 *
 * Media SfilStoredFile
 *
 * @package jj_media
 * @subpackage jj_media.models
 */
class SfilStoredFile extends JjMediaAppModel {

	var $name = 'SfilStoredFile';

	var $useDbConfig = 'assets';
	
	var $validate = array(
		'checksum' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'dirname' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'basename' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'original_filename' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'mime_type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'size' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);


/**
 * actsAs property
 *
 * @var array
 * @access public
 */
	var $actsAs = array(
		'Containable',
		'Media.Transfer' => array(
			'trustClient' => false,
			'transferDirectory' => MEDIA_TRANSFER,
			'createDirectory' => true,
			'alternativeFile' => 100
		),
		'JjMedia.GeneratorPlus' => array(
			'scopeField' => 'transformation'
		),
		'Media.Generator' => array(
			'baseDirectory' => MEDIA_TRANSFER,
			'filterDirectory' => MEDIA_FILTER,
			'createDirectory' => true,
		),
		'Media.Coupler' => array(
			'baseDirectory' => MEDIA_TRANSFER
		),
		'Media.Meta' => array(
			'level' => 2
		)
	);

/**
 * Reimplements the TransferBehavior::transferTo() method from Media plugin
 * 
 * @access public
 * @return array 
 */
	function transferTo($via, $from) {
		extract($from);

		$irregular = array(
			'image' => 'img',
			'text' => 'txt'
		);
		$name = Mime_Type::guessName($mimeType ? $mimeType : $file);

		if (isset($irregular[$name])) {
			$short = $irregular[$name];
		} else {
			$short = substr($name, 0, 3);
		}
		
		$extension = !empty($extension) ? '.' . strtolower($extension) : null;
		
		$newFilename  = uniqid('', true) . $extension;
		
		$this->data[$this->alias]['original_filename'] = $filename . $extension;
		if (is_string($this->data[$this->alias]['file']))
			$this->data[$this->alias]['file'] = dirname($this->data[$this->alias]['file']) . DS . $newFilename;
		
		return $short . DS . $newFilename;
	}
}
