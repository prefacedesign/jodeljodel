<?php
	echo $this->Bl->scaixote(array(),array('size' => array('M' => 12)));
		$i = 1;

		foreach($data as $k => $noticia)
		{

			echo $this->Bl->scaixa(array(),array('size' => array('M' => 3)));
				echo $this->Bl->scoluna();
					echo $this->element('news_new', array('plugin' => 'new', 'type' => array('preview'), 'data' => $noticia));
				echo $this->Bl->ecoluna();
			echo $this->Bl->ecaixa();

			if ($i % 4 == 0)
				echo $this->Bl->floatBreak();

			$i++;
		}
	echo $this->Bl->ecaixote();
?>
