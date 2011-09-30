<?php

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