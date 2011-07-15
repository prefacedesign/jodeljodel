<?php

class Document extends BurocrataUserAppModel {
	var $name = 'Document';
	
	var $actsAs = array(
		'ContentStream.CsContentStreamHolder' => array(
			'type' => array(
				'content_stream_id' => 'document',
				// 'content_stream_id' => array('type' => 'document')
				// 'content_stream_id' => array('streams' => array('text', 'image')
				// 'content_stream_id' => array('type' => 'document', 'callbacks' => array('create' => array('controller' => 'x')))
			)
		)
	);
}