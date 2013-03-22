<?php

class CsTest extends AppModel
{
	var $actsAs = array(
		'Containable',
		'ContentStream.CsContentStreamHolder' => array(
			'streams' => array(
				'cs_content_stream_id' => 'document'
			)
		)
	);
}
