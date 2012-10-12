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

	echo  $this->Bl->sboxContainer(array(), array('size' => array('M' => 7, 'g' => -1)));
		echo $this->Bl->sdiv();
			echo  $this->Bl->sbox(array('class' => 'subtitle'), array('size' => array('M' => 2, 'g' => -1)));
				echo __d('corktile', 'Location in the site');
			echo $this->Bl->ebox();
		echo $this->Bl->ediv();
		echo $this->Bl->sdiv();
			echo  $this->Bl->sboxContainer(array(), array('size' => array('M' => 5, 'g' => -1)));
				
				$linkList = array();
				$moduleContext = &$pageSections;
				foreach($this->data['CorkCorktile']['location'] as $local)
				{
					if (isset($moduleContext[$local]['humanName']))
						$linkList[] = array('name' => __($moduleContext[$local]['humanName'], true), 'url' => $moduleContext[$local]['url']);
					
					if (isset($moduleContext[$local]['subSections']))
						$moduleContext = &$moduleContext[$local]['subSections'];
				}
				echo $this->Bl->anchorList(array(),array('separator' => ' &rarr; ', 'lastSeparator' => ' &rarr; ', 'linkList' => $linkList));
				
			echo $this->Bl->eboxContainer();
		echo $this->Bl->ediv();
		echo $this->Bl->floatBreak();
		echo $this->Bl->sdiv();
			echo  $this->Bl->sbox(array('class' => 'subtitle'), array('size' => array('M' => 2, 'g' => -1)));
				echo __d('corktile', 'Description');
			echo $this->Bl->ebox();
		echo $this->Bl->ediv();
		echo $this->Bl->sdiv();
			echo  $this->Bl->sboxContainer(array(), array('size' => array('M' => 5, 'g' => -1)));
				echo $this->Bl->span(array(), array(), $this->data['CorkCorktile']['title']);
			echo $this->Bl->eboxContainer();
		echo $this->Bl->ediv();
		echo $this->Bl->floatBreak();
		echo  $this->Bl->sboxContainer(array('class' => 'info'), array('size' => array('M' => 7, 'g' => -1)));
			echo  $this->Bl->sbox(array(), array());
				echo $this->Bl->span(array(), array(), $this->data['CorkCorktile']['instructions']);
			echo $this->Bl->ebox();
		echo $this->Bl->eboxContainer();
		echo $this->Bl->floatBreak();
	echo $this->Bl->eboxContainer();
	echo $this->Bl->floatBreak();
?>