<?php
class CsItem extends ContentStreamAppModel
{
	var $name = 'CsItem';
	var $belongsTo = array('ContentStream.CsContentStream');
	var $actsAs = array(
		'JjUtils.Ordered' => array(
			'field' => 'order',
			'foreign_key' => 'cs_content_straem_id'
		)
	);
}