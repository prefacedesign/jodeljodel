<?php

switch ($type[0])
{
	case 'full':
		echo $this->Bl->anchor(
			array(),
			array(
				'url' => $this->Bl->fileUrl($data['SfilStoredFile']['id'], false, true)
			),
			$data['SfilStoredFile']['original_filename']
		);
		
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
		echo $this->Bl->spanDry($size);
	break;
	
	case 'buro':
		switch ($type[1])
		{
			case 'form':
				echo $this->Buro->sform(array(), array('model' => 'PieFile.PieFile'));
					
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
					
					echo $this->Buro->submit(array(), array('cancel' => true));
					
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