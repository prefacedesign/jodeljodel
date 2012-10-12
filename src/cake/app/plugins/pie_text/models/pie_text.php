<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

class PieText extends PieTextAppModel
{
/**
 * Model name
 * 
 * @var string
 * @access public
 */
	var $name = 'PieText';

/**
 * beforeSave callback
 * 
 * Used to process the text in textile format.
 * 
 * @access public
 * @return Always true so it doesnt avoid saving
 */
	function beforeSave()
	{
		App::import('Vendor', 'Textile');
		$Textile = new Textile;
		$this->data[$this->alias]['processed_text'] = $Textile->textileThis($this->data[$this->alias]['text']);
		return true;
	}
}