<?php
class CsContentStream extends ContentStreamAppModel
{
	var $name = 'CsContentStream';
	var $hasMany = array('ContentStream.CsItem');
}