<?php
	echo $this->Bl->scaixote(array(),array('size' => array('M' => 12)));
		$i = 1;

		foreach($data as $k => $event)
		{

			echo $this->Bl->scaixa(array(),array('size' => array('M' => 6)));
				echo $this->Bl->scoluna();
					echo $this->element('eve_event', array('plugin' => 'event', 'type' => array('preview'), 'data' => $event));
				echo $this->Bl->ecoluna();
			echo $this->Bl->ecaixa();

			if ($i % 2 == 0)
				echo $this->Bl->floatBreak();

			$i++;
		}
	echo $this->Bl->ecaixote();
?>
