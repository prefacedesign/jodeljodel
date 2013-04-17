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
 * Model for content_stream plugin.
 *
 * PHP versions 5
 *
 * @package       jodel
 * @subpackage    jodel.content_stream.models
 */

/**
 * CsContentStream.
 *
 * Model that contains some methods for deal with finds and saves.
 *
 * @package       jodel
 * @subpackage    jodel.content_stream.models
 */
class CsContentStream extends ContentStreamAppModel
{
/**
 * Class name
 * 
 * @var string
 * @access public
 */
	public $name = 'CsContentStream';

/**
 * hasMany relationship
 * 
 * @var array
 * @access public
 */
	public $hasMany = array(
		'CsItem' => array(
			'className' => 'ContentStream.CsItem',
			'order' => 'CsItem.order',
			'dependent' => true
		)
	);

/**
 * This method creates a new (and empty) Content Stream
 * 
 * @access public
 * @param $type string The type of ContentStream defined on config
 * @return mixed The result of save method
 */
	public function createEmpty($type)
	{
		$this->create(array($this->alias => compact('type')));
		return $this->save();
	}
}