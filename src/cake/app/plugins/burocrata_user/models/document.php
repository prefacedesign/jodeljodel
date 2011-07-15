<?php

class Document extends BurocrataUserAppModel {
	var $name = 'Document';
	
	var $actsAs = array(
		'ContentStream.CsContentStreamHolder' => array(
			'type' => array(
				'content_stream_id' => 'document'
			)
		)
	);
}