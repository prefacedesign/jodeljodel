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


//This is the place for all elements related to one entry of data
//from the module
// array('buro','form')
// array('buro','form','special')
// array('preview')
// array('data')
switch ($type[0])
{
	case 'buro':
		if ($type[1] == 'form')
		{	
			echo $buro->sform(array(), array(
				'model' => $fullModelName,
				'callbacks' => array(
					'onReject' => array('js' => '$("content").scrollTo(); showPopup("error");', 'contentUpdate' => 'replace'),
					'onSave' => array('js' => '$("content").scrollTo(); showPopup("notice");'),
				)
			));
				
				echo $buro->submitBox(array(),array('publishControls' => false));
			echo $buro->eform();
		}
	break;
	
	case 'type':
	break;
}

?>