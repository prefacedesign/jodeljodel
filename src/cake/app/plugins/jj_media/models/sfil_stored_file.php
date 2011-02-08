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

	var $belongsTo = array(
		'Original' => array(
			'className' => 'JjMedia.SfilStoredFile',
			'foreignKey' => 'original_id'
		)
	);

	var $hasMany = array('DinFile');


/**
 * actsAs property
 *
 * @var array
 * @access public
 */
	var $actsAs = array(
		'Containable',
		'JjMedia.TransferPlus',
		'Media.Transfer' => array(
			'trustClient' => false,
			'transferDirectory' => MEDIA_TRANSFER,
			'createDirectory' => true,
			'alternativeFile' => 100
		),
		'Media.Coupler' => array(
			'baseDirectory' => MEDIA_TRANSFER
		),
		'Media.Meta' => array(
			'level' => 2
		)
	);
}