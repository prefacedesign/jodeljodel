<?php
class CsContentStream extends ContentStreamAppModel
{
	var $name = 'CsContentStream';
	var $hasMany = array('ContentStream.CsItem');
	
	function createEmpty($type)
	{
		$this->create(array($this->alias => compact('type')));
		return $this->save();
	}
}