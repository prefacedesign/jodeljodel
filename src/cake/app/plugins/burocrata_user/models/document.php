<?php
	class Document extends BurocrataUserAppModel {
		var $name = 'Document';
		
		var $actsAs = array(
			'ContentStream.CsContentStreamerHolder' => array(
				'foraignKey' => 'content_stream_id',
				'type' => 'document'
			)
		);
	}