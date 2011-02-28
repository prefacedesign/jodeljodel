<?php
	echo $this->Bl->scaixa(array(),array('size' => array('M' => 7)));
		echo $this->Bl->scoluna();
			echo $this->element('news_new', array('plugin' => 'news_new', 'type' => array('full'), 'dados' => $data));
		echo $this->Bl->ecoluna();
	echo $this->Bl->ecaixa();
?>
