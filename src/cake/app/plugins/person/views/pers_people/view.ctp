<?php
	echo $this->Bl->scaixa(array(),array('size' => array('M' => 5)));
		echo $this->Bl->scoluna();
			echo $this->element('pers_person', array('plugin' => 'person', 'type' => array('full'), 'data' => $data));
		echo $this->Bl->ecoluna();
	echo $this->Bl->ecaixa();