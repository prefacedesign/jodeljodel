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

if ($type[0] == 'cork') {
	$type = array('full','cork','');
}

switch ($type[0])
{
	case 'full':
		switch ($type[1])
		{
			case 'cork':
				switch ($type[2])
				{
					default:
						if (empty($data['PieImageCork']['file_id'])) {
							return;
						}

						$url = false;
						$htmlAttr = array();
						$assine =
							!empty($data['CorkCorktile']['options']['type'])
							&& $data['CorkCorktile']['options']['type'] == 'assine_revista';

						$version = '';
						if (isset($type[2]) && ($type[2] == 'quem_somos' || $type[2] == 'historia')) {
							$version = 'preview_6M';
						}
						elseif (isset($data['CorkCorktile']['options']['type']) && $data['CorkCorktile']['options']['type'] == 'equipe') {
							$version = 'preview_8M';
						}

						if ($assine) {
							$prop = $this->Bl->imageProperties($data['PieImageCork']['file_id'], $version);
							if ($prop['properties'][0] != 303) {
								echo $this->Bl->span(array('style' => 'display:none'), array(), 'A imagem não está de acordo com as especificações.');
								return;
							}
						}

						$src = $this->Bl->imageURL($data['PieImageCork']['file_id'], $version);

						if (!empty($data['PieImageCork']['link']) && $data['PieImageCork']['link_type'] == 'external') {
							$url = $data['PieImageCork']['link'];
							$htmlAttr = array('target' => '_blank');
						}
						elseif ($data['PieImageCork']['link_type'] == 'own') {
							$url = $this->Bl->imageURL($data['PieImageCork']['file_id']);
						}

						if (!empty($url)) {
							echo $this->Bl->sanchor($htmlAttr, array('url' => $url));
						}

						echo $this->Bl->span(
							array('class' => 'fancy-border image ' . $version), array(),
							$this->Bl->img(array(
								'src' => $src,
								'alt' => ''
							))
						);

						if (!empty($url)) {
							echo $this->Bl->eanchor();
						}

						echo $this->Bl->p(array('class' => 'subtitle'), array(),
							$this->Bl->spanDry($data['PieImageCork']['title']) . ' ' . $data['PieImageCork']['subtitle']
						);
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
					echo $this->Buro->sform(array(), array('model' => 'PieImage.PieImageCork'));
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

					$usesTitleAndDescription =
						empty($this->data['CorkCorktile']['options']['type'])
						|| $this->data['CorkCorktile']['options']['type'] != 'assine_revista';

					if ($usesTitleAndDescription) {
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
					}

					echo $this->Buro->input(array('id' => $selectId = uniqid('sel')), array(
						'type' => 'select',
						'fieldName' => 'link_type',
						'label' => __d('content_stream', 'PieImage.link_type label',true),
						'instructions' => __d('content_stream', 'PieImage.link_type instructions',true),
						'options' => array('options' => array(
							'none' => __d('content_stream', 'PieImage.link_type none',true),
							'own' => __d('content_stream', 'PieImage.link_type own',true),
							'external' => __d('content_stream', 'PieImage.link_type external',true),
						))
					));
					
					echo $this->Buro->input(array(),array(
						'type' => 'text',
						'fieldName' => 'link',
						'label' => __d('content_stream', 'PieImage.link label',true),
						'instructions' => __d('content_stream', 'PieImage.link instructions',true),
						'container' => array(
							'id' => $linkInput = uniqid('inp')
						)
					));

					echo $this->Html->scriptBlock("
						var changeHandler = function(ev) {
							if ($('$selectId').value == 'external')
								$('$linkInput').show();
							else
								$('$linkInput').hide();
						};
						$('$selectId').on('change', changeHandler);
						changeHandler();
					");

					echo $this->Bl->br();
					
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
				if (!empty($data['PieImageCork']['title']))
					echo $this->Bl->h3Dry($data['PieImageCork']['title']);
				if (!empty($data['PieImageCork']['subtitle']))
					echo $this->Bl->pDry($data['PieImageCork']['subtitle']);
				if (!empty($data['PieImageCork']['file_id']))
					echo $this->Bl->img(array(), array('id' => $data['PieImageCork']['file_id'], 'version' => 'backstage_preview'));
			break;
		}
	break;
}
