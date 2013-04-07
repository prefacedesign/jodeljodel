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
	case 'full':
		switch ($type[1])
		{
			case 'cork':
				if (!empty($data['PieText']['processed_text']))
					echo $data['PieText']['processed_text'];
				else
					echo $this->Bl->paraDry(explode("\n", $data['PieText']['text']));
			break;
		}
	break;
	
	case 'buro':
		switch ($type[1])
		{
			case 'form':
				echo $this->Buro->sform(array(), array('model' => 'PieText.PieText'));
					
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
							'fieldName' => 'text',
							'type' => 'textile',
							'label' => __d('content_stream', 'PieText.text label', true),
							'instructions' => __d('content_stream', 'PieText.text instructions', true),
							'options' => array(
								'enabled_buttons' => array('bold', 'italic', 'link', 'subscript', 'superscript'),
								'allow_preview' => false
							)
						)
					);
					
					echo $this->Buro->submit(array(), array('cancel' => true));
					
				echo $this->Buro->eform();
				echo $this->Bl->floatBreak();
			break;
			
			case 'view':
				echo $data['PieText']['processed_text'];
			break;
		}
	break;
}
