<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */


switch ($type[0])
{
	case 'full':
		switch ($data['PieTitle']['level'])
		{
			case 1:
				echo $this->Bl->h3Dry($data['PieTitle']['title']);
			break;
			case 2:
				echo $this->Bl->h4Dry($data['PieTitle']['title']);
			break;
		}
	break;
	
	case 'buro':
		switch ($type[1])
		{
			case 'form':
				if (isset($type[2]) && $type[2] == 'cork')
				{
					echo $this->Buro->sform(array(), array(
						'model' => $fullModelName,
						'type' => array('cork'),
						'callbacks' => array(
							'onReject' => array('js' => '$("content").scrollTo(); showPopup("error");', 'contentUpdate' => 'replace'),
							'onSave' => array('js' => '$("content").scrollTo(); showPopup("notice");'),
						)
					));
				}
				else
				{
					echo $this->Buro->sform(array(), array('model' => 'PieTitle.PieTitle'));
				}
					
					echo $this->Buro->input(
						array(),
						array(
							'fieldName' => 'id',
							'type' => 'hidden'
						)
					);
					
					echo $this->Buro->input(
						array(), 
						array(
							'fieldName' => 'level',
							'type' => 'select',
							'label' => __d('content_stream', 'PieTitle.level label', true),
							'instructions' => __d('content_stream', 'PieTitle.level instructions', true),
							'options' => array(
								'options' => array(
									1 => __d('content_stream', 'PieTitle level 1', true),
									2 => __d('content_stream', 'PieTitle level 2', true),
								)
							)
						)
					);
					
					echo $this->Buro->input(
						array(), 
						array(
							'fieldName' => 'title',
							'type' => 'text',
							'label' => __d('content_stream', 'PieTitle.title label', true),
							'instructions' => __d('content_stream', 'PieTitle.title instructions', true)
						)
					);
					
					if (isset($type[2]) && $type[2] == 'cork')
					{
						echo $this->Buro->submitBox(array(), array('publishControls' => false));
					}
					else
					{
						echo $this->Buro->submit(array(), array('cancel' => true));
					}
					
				echo $this->Buro->eform();
				echo $this->Bl->floatBreak();
			break;
			
			case 'view':
				switch ($data['PieTitle']['level'])
				{
					case 1:
						echo $this->Bl->h3Dry($data['PieTitle']['title']);
					break;
					case 2:
						echo $this->Bl->h4Dry($data['PieTitle']['title']);
					break;
				}
			break;
		}
	break;
}
