<?php
	echo $this->Bl->scaixote(array(),array('size' => array('M' => 12)));
		$i = 1;
		foreach($data as $k => $personData)
		{	
			echo $this->Bl->scaixa(array(),array('size' => array('M' => 4)));
				echo $this->Bl->scoluna();
					echo $this->element('pers_person', array('plugin' => 'person', 'type' => array('preview'), 'data' => $personData));
				echo $this->Bl->ecoluna();
			echo $this->Bl->ecaixa();
			
			if ($i % 3 == 0)
				echo $this->Bl->floatBreak();
				
			$i++;
		}
	echo $this->Bl->ecaixote();
?>