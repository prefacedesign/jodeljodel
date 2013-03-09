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
		$name = Mime_Type::guessName(MEDIA_TRANSFER . $data['SfilStoredFile']['dirname'] . DS . $data['SfilStoredFile']['basename']);
		$mime = $data['SfilStoredFile']['mime_type'];
		$img_name = false;
		switch ($name)
		{
			case 'image': $img_name = 'picture.png'; break;
			case 'audio': $img_name = 'music.png'; break;
			case 'video': $img_name = 'film.png'; break;
			
			case 'text':
			case 'document':
				if (strpos($mime, 'pdf') !== false)
					$img_name = 'page_white_acrobat.png';
				else
					$img_name = 'page_white_text.png';
			break;
			
			default:
				if (strpos($mime, 'zip') !== false)
					$img_name = 'page_white_zip.png';
				elseif (strpos($mime, 'excel') !== false)
					$img_name = 'page_white_excel.png';
				elseif (strpos($mime, 'spreadsheet') !== false)
					$img_name = 'page_white_excel.png';
				elseif (strpos($mime, 'wordprocessing') !== false)
					$img_name = 'page_white_word.png';
				elseif (strpos($mime, 'rar') !== false)
					$img_name = 'page_white_zip.png';
				elseif (strpos($mime, 'x-csrc') !== false)
					$img_name = 'page_white_c.png';
				else
					$img_name = 'page_white.png';
		}
		
		if ($img_name)
			echo $this->Bl->img(array('src' => $this->Bl->url('/pie_file/img/'.$img_name))), '&ensp;';
		
		echo $this->Bl->anchor(
			array('class' => 'visitable'),
			array(
				'url' => $this->Bl->fileUrl($data['SfilStoredFile']['id'], false, true)
			),
			!empty($data['PieFile']['title']) ? $data['PieFile']['title'] : $data['SfilStoredFile']['original_filename']
		), '&ensp;';
		
		// File size
		$labels = array('', 'K', 'M', 'G');
		$size = $data['SfilStoredFile']['size'];
		$i = 0;
		while ($size > 1000)
		{
			$size /= 1024;
			$i++;
		}
		
		$size = round($size, 3-log($size, 10)) . ' ' . $labels[$i] . 'B';
		echo $this->Bl->span(array('class' => 'light'), array(), $size);
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
					echo $this->Buro->sform(array(), array('model' => 'PieFile.PieFile'));
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
							'type' => 'upload',
							'label' => __d('content_stream', 'PieFile.file_id label', true),
							'instructions' => __d('content_stream', 'PieFile.file_id instructions', true)
						)
					);
					
					// echo $this->Buro->input(
						// array(),
						// array(
							// 'fieldName' => 'download_name',
							// 'type' => 'text',
							// 'label' => __d('content_stream', 'PieFile.download_name label', true),
							// 'instructions' => __d('content_stream', 'PieFile.download_name instructions', true)
						// )
					// );
					
					echo $this->Buro->input(
						array(),
						array(
							'fieldName' => 'title',
							'type' => 'text',
							'label' => __d('content_stream', 'PieFile.title label', true),
							'instructions' => __d('content_stream', 'PieFile.title instructions', true)
						)
					);
					
					echo $this->Buro->input(
						array(),
						array(
							'fieldName' => 'description',
							'type' => 'textarea',
							'label' => __d('content_stream', 'PieFile.description label', true),
							'instructions' => __d('content_stream', 'PieFile.description instructions', true)
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
				if (!empty($data['PieFile']['title']))
					echo $this->Bl->h3Dry($data['PieFile']['title']);
				if (!empty($data['PieFile']['description']))
					echo $this->Bl->pDry($data['PieFile']['description']);
				if (!empty($data['SfilStoredFile']['id']))
					echo $this->Bl->pDry(
						__d('content_stream', 'PieFile - Download file:', true)
						. ' '
						. $this->Bl->anchor(
							array(), array('url' => $this->Bl->fileUrl($data['SfilStoredFile']['id'])),
							$data['SfilStoredFile']['original_filename']
						)
					);
			break;
		}
	break;
}
