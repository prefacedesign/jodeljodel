<?php
class CsCork extends ContentStreamAppModel
{
	var $name = 'CsCork';
	
	var $actsAs = array(
		'Containable', 
		'Corktile.CorkAttachable' => array('type' => 'cs_cork'),
	);
	
	function saveCorkContent($content = array(), $options = array(), $fromForm = false)
	{
		if (!isset($options['options']['cs_type']))
			$options['options']['cs_type'] = 'cork';
		
		$content['CsCork']['type'] = $options['options']['cs_type'];
		$this->attachContentStream($options['options']['cs_type']);
		
		if ($this->save($content))
			return $this->id;
		else
			return false;
	}
	
	function getCorkContent($id, $options = array())
	{
		$this->contain();
		$data = $this->findById($id);
		
		$this->attachContentStream($data[$this->alias]['type']);
		return $data;
	}
	
	function attachContentStream($cs_type)
	{
		$this->Behaviors->attach('ContentStream.CsContentStreamHolder', array(
			'streams' => array('cs_content_stream_id' => $cs_type)
		));
	}
}