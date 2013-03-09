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
		switch ($type[1])
		{
			case 'cork':
				switch ($type[2])
				{
					default:
						if (!empty($data['PieImage']['file_id']))
						{
							echo $this->Bl->img(array(), array('id' => $data['PieImage']['file_id']));
							echo $this->Bl->p(array('class' => 'subtitle'), array(),
								$this->Bl->spanDry($data['PieImage']['title']) . ' ' . $data['PieImage']['subtitle']
							);
						}
				}
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
					echo $this->Buro->sform(array(), array('model' => 'PieImage.PieImage'));
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
							'fieldName' => 'file_id',
							'type' => 'image',
							'label' => __d('content_stream', 'PieImage.file_id label', true),
							'instructions' => __d('content_stream', 'PieImage.file_id instructions', true),
							'options' => array(
								'version' => 'backstage_preview'
							)
						)
					);
					
					echo $this->Buro->input(
						array(),
						array(
							'fieldName' => 'title',
							'type' => 'text',
							'label' => __d('content_stream', 'PieImage.title label', true),
							'instructions' => __d('content_stream', 'PieImage.title instructions', true)
						)
					);
					
					echo $this->Buro->input(
						array(),
						array(
							'fieldName' => 'subtitle',
							'type' => 'textarea',
							'label' => __d('content_stream', 'PieImage.subtitle label', true),
							'instructions' => __d('content_stream', 'PieImage.subtitle instructions', true)
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
				if (!empty($data['PieImage']['title']))
					echo $this->Bl->h3Dry($data['PieImage']['title']);
				if (!empty($data['PieImage']['subtitle']))
					echo $this->Bl->pDry($data['PieImage']['subtitle']);
				if (!empty($data['PieImage']['file_id']))
					echo $this->Bl->img(array(), array('id' => $data['PieImage']['file_id'], 'version' => 'backstage_preview'));
			break;
		}
	break;
}
