<?php
class CsItem extends ContentStreamAppModel
{
	var $name = 'CsItem';
	var $belongsTo = array('ContentStream.CsContentStream');
}