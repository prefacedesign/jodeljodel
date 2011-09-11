<?php

class Document extends BurocrataUserAppModel {
	var $name = 'Document';
	
	var $actsAs = array(
		'ContentStream.CsContentStreamHolder' => array(
			'streams' => array(
				'content_stream_id' => 'document',
				// 'content_stream_id' => array('type' => 'document')
				// 'content_stream_id' => array('type' => 'document', 'callbacks' => array('create' => array('controller' => 'x')))
				// 'content_stream_id' => array('allowedContents' => array('text', 'image'))
			)
		)
	);
}