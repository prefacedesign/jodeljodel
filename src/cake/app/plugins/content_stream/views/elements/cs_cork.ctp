<?php

switch ($type[0])
{
	case 'buro':
		if ($type[1] == 'form')
		{
			$contentStreamLabel = 'Corktile input label for ' . $this->data['CsCork']['type'];
			$contentStreamInstructions = 'Corktile input instructions for ' . $this->data['CsCork']['type'];
			echo $this->Buro->sform(array(),array('model' => 'ContentStream.CsCork'));
				echo $this->Buro->input(
					array(),
					array('fieldName' => 'id', 'type' => 'hidden')
				);
				echo $this->Buro->input(
					array(),
					array(
						'type' => 'content_stream',
						'foreignKey' => 'cs_content_stream_id',
						'label' => __d('content_stream', $contentStreamLabel, true),
						'instructions' => __d('content_stream', $contentStreamInstructions, true)
					)
				);
			echo $this->Buro->eform();
		}
	break;
	
	case 'cork':
		$type = array('full', 'cork');
		if (!empty($options['type']))
			$type[] = $options['type'];
		
		echo $this->Jodel->insertModule('ContentStream.CsContentStream', $type, $data['CsCork']['cs_content_stream_id']);
	break;
}