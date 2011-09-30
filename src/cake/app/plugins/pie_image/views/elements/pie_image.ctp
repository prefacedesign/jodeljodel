<?php

switch ($type[0])
{
	case 'buro':
		switch ($type[1])
		{
			case 'form':
				echo $this->Buro->sform(array(), array('model' => 'PieImage.PieImage'));
					
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
					
					echo $this->Buro->submit(array(), array('cancel' => true));
					
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