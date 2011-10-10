<?php

switch ($type[0])
{
	case 'buro':
		if ($type[1] == 'form')
		{
			echo $this->Buro->sform(array(),array('model' => 'ContentStream.CsCork'));
				echo $this->Buro->input(
					array(),
					array('fieldName' => 'id', 'type' => 'hidden')
				);
				echo $this->Buro->input(
					array(),
					array('type' => 'content_stream', 'foreignKey' => 'cs_content_stream_id')
				);
			echo $this->Buro->eform();
		}
	break;
	
	case 'cork':
		echo $this->Jodel->insertModule('ContentStream.CsContentStream', array('cork'), $data['CsCork']['cs_content_stream_id']);
	break;
}