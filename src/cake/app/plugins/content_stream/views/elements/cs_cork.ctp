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


switch ($type[0])
{
	case 'buro':
		if ($type[1] == 'form')
		{
			$contentStreamLabel = 'Corktile input label for ' . $this->data['CsCork']['type'];
			$contentStreamInstructions = 'Corktile input instructions for ' . $this->data['CsCork']['type'];
			echo $this->Buro->sform(array(),array(
				'model' => 'ContentStream.CsCork',
				'callbacks' => array(
					'onStart' => array('js' => '$("content").setLoading();'), 
					'onReject' => array('contentUpdate' => 'replace', 'js' => '$("content").unsetLoading(); $("content").down(".error").scrollTo(); showPopup("error");'),
					'onSave' => array('js' => '$("content").unsetLoading(); $("content").scrollTo(); showPopup("notice");'),
				)
			));
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
				echo $this->Buro->submitBox(array(),array('publishControls' => false));
			echo $this->Buro->eform();
		}
	break;
	
	case 'cork':
		$type = array('full', 'cork');
		if (!empty($options['type']))
			$type[] = $options['type'];
		else
			$type[] = false;
		
		echo $this->Jodel->insertModule('ContentStream.CsContentStream', $type, $data['CsCork']['cs_content_stream_id']);
	break;
}