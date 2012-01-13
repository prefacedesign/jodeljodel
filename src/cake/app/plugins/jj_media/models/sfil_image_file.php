<?php

App::import('JjMedia.SfilStoredFile');

class SfilImageFile extends SfilStoredFile
{
	var $name = 'SfilImageFile';
	var $useTable = 'sfil_stored_files';
	
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
		'file' => array(
			'resource'   => array('rule' => 'checkResource'),
			'access'     => array('rule' => 'checkAccess'),
			'location'   => array('rule' => array('checkLocation', array(MEDIA_TRANSFER, '/tmp/'))),
			'permission' => array('rule' => array('checkPermission', '*')),
			'size'       => array('rule' => array('checkSize', '5M')),
			'validImage' => array('rule' => array('checkMimeType', false, array('image/jpeg', 'image/png', 'image/tiff', 'image/gif', 'application/pdf')))
		),
	);
}
