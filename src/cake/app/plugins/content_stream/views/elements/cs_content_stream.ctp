<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */


if (empty($data) || !is_string($data))
{
	trigger_error('ContentStream - must passed the content stream ID');
}
else
{
	$ContentStream = ClassRegistry::init('ContentStream.CsContentStream');
	$id = $data;
	$data = $ContentStream->findById($id);
	
	if (empty($data))
	{
		trigger_error('ContentStream - content stream of ID = '.$id.' not found.');
		$data['CsItem'] = array();
	}
	
	foreach ($data['CsItem'] as $n => $item)
	{
		echo $this->Jodel->insertModule('ContentStream.CsItem', $type, array('CsItem' => $item));
		if ($type[0] == 'preview' && $n == 1)
			break;
	}
}