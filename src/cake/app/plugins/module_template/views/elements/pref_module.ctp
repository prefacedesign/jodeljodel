<?php

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