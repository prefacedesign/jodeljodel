<?php

	echo $this->Bl->scaixote(array(),array('size' => array('M' => 12)));
		$i = 1;

		foreach($data as $k => $publicacao)
		{
			$publicacao['id'] = $k;
			echo $this->Bl->scaixa(array(),array('size' => array('M' => 4)));
				echo $this->Bl->scoluna();
					echo $this->element('pap_paper', array('plugin' => 'paper', 'type' => array('preview'), 'data' => $publicacao));
				echo $this->Bl->ecoluna();
			echo $this->Bl->ecaixa();

			if ($i % 3 == 0)
				echo $this->Bl->floatBreak();

			$i++;
		}
	echo $this->Bl->ecaixote();
?>