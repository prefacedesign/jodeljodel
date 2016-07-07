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
App::import('Core', 'File');

/**
 * Media enhanced plugin
 *
 * Media SfilStoredFile model uses the Media plugin behavior
 *
 * Usage: is enough to this model pass the 'file' parameter to Model::save method.
 * 
 * {{{
 * 	$this->SfilStoredFile->save($this->data); // When the data comes from one POST with input[type=file] on it.
 * 	
 * 	$data = array(
 * 		'SfilStoredFile' => array('file' => '/full/path/to_file')
 * 	);
 * 	$this->SfilStoredFile->save($data); // When there is no data from POST and the file is already on server.
 * }}}
 * 
 * The Media plugin have some Console scripts to handle filtering, and database/filtering
 * consistency. For make this model to work with thoses scripts, nothing have to be done
 * besides the model name specifying:
 * 
 * {{{
 *  sudo -u www-data ./cake media sync JjMedia.SfilStoredFile -auto
 * }}}
 * 
 * This script will delete any files that doesnt have an database record and will try
 * to recover files from database record without file (by using checksum for each found
 * file) or delete when recover doesnt work.
 * 
 * {{{
 *  sudo -u www-data ./cake media make -model JjMedia.SfilStoredFile
 * }}}
 * 
 * This script will rebuild all filtered files, so is a good pratice to remove the filter
 * folder before run it.
 * 
 * Note that the scripts calls are using the `sudo -u www-data`, that way, the script
 * runs under the apache user permissions and all created files will belongs to www-data
 * 
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
		'file' => array(
			'resource'   => array('rule' => 'checkResource'),
			'access'     => array('rule' => 'checkAccess'),
			'location'   => array('rule' => array('checkLocation', array(
				MEDIA_TRANSFER, '/tmp/', 'D:\wamp\tmp'
			))),
			'permission' => array('rule' => array('checkPermission', '*')),
			'size'       => array('rule' => array('checkSize', '5M')),
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
			'overwrite' => true,
		),
		'Media.Coupler' => array(
			'baseDirectory' => MEDIA_TRANSFER
		),
		'Media.Meta' => array(
			'level' => 2
		)
	);

	/**
	 * @param int    $file_id
	 * @param string $version
	 *
	 * @return bool|string
	 */
	public function webPath ($file_id, $version = null) {
		$this->Behaviors->disable('Coupler');
		$data = $this->find('first', array('conditions' => array('id' => $file_id)));
		$this->Behaviors->enable('Coupler');

		if (empty($data)) {
			return false;
		}

		/**
		 * @var string $basename
		 * @var string $dirname
		 * @var string $transformation
		 */
		extract($data[$this->alias], EXTR_SKIP);
		if (empty($version)) {
			return '/' . MEDIA_TRANSFER_URL . "{$dirname}/{$basename}";
		}

		return '/' . MEDIA_FILTER_URL . "{$transformation}_{$version}/{$dirname}/{$basename}";
	}

/**
 * Return the properties of an image
 *
 * Used to return the properties of an image
 * @access public
 * @param integer $id The id of the image
 * @param string  $version The version of the image
 *
 */
	function properties($id, $version = false)
	{	
		if (empty($id))
			return array();
		
		$this->contain();
		$file_data = $this->findById($id);
		
		if (empty($file_data)) {
			return array();
		}

		$id = $file_data[$this->alias]['basename'];
		if (empty($version))
		{
			$path = MEDIA_TRANSFER . $file_data[$this->alias]['dirname'] . DS . $id;
			$webroot_path = '/' . MEDIA_TRANSFER_URL . $file_data[$this->alias]['dirname'] . '/' . $id;
		}
		else
		{
			if (!empty($file_data[$this->alias]['transformation']))
				$version = $file_data[$this->alias]['transformation'] . '_' . $version;
			
			$path = MEDIA_FILTER . $version . DS . $file_data[$this->alias]['dirname'] . DS . $id;
			$webroot_path = '/' . MEDIA_FILTER_URL . $version . '/' . $file_data[$this->alias]['dirname'] . '/' . $id;
		}

		if (file_exists($path))
		{
			$properties = getimagesize($path);
			$data = $file_data[$this->alias];
			$data['remote'] = 0;
			return compact('properties', 'path', 'webroot_path', 'data');
		}

		return false;
	}
	
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
		
		return $short . DS . $newFilename;
	}
	
	function make($file)
	{
		$fileData = $this->findByBasename(basename($file));
		if (!empty($fileData))
		{
			$this->createGeneratorConfigure($fileData[$this->alias]['transformation']);
			return $this->Behaviors->dispatchMethod($this, 'make', array($file));
		}
		return false;
	}
}
