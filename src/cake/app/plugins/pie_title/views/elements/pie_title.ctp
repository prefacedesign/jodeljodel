<?php

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
				echo $this->Buro->sform(array(), array('model' => 'PieTitle.PieTitle'));
					
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
					
					echo $this->Buro->submit(array(), array('cancel' => true));
					
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