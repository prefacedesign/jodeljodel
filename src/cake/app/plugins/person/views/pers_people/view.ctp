<?php
	echo $this->Bl->scaixa(array(),array('size' => array('M' => 8)));
		echo $this->element('pers_person', array('plugin' => 'person', 'type' => array('full'), 'data' => $data));
	echo $this->Bl->ecaixa();