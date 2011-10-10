<?php
	$modules = Configure::read('PageSections.sections');
	
	echo  $this->Bl->sboxContainer(array(), array('size' => array('M' => 7, 'g' => -1)));
		echo $this->Bl->sdiv();
			echo  $this->Bl->sbox(array('class' => 'subtitle'), array('size' => array('M' => 2, 'g' => -1)));
				echo __d('corktile', 'Location in the site');
			echo $this->Bl->ebox();
		echo $this->Bl->ediv();
		echo $this->Bl->sdiv();
			echo  $this->Bl->sboxContainer(array(), array('size' => array('M' => 5, 'g' => -1)));
				$linkList = array();
				foreach($this->data['CorkCorktile']['location'] as $local)
				{
					if (isset($modules[$local]['humanName']))
						$linkList[] = array('name' => __($modules[$local]['humanName'], true), 'url' => $modules[$local]['url']);
					else
					{
						$mod = $modules[$exLocal]['subSections'];
						$linkList[] = array('name' => __($mod[$local]['humanName'], true), 'url' => $mod[$local]['url']);
					}
					$exLocal = $local;
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