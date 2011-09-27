<?php
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