<?php

	echo $this->Bl->scaixote(array(),array('size' => array('M' => 12)));
		echo $this->Bl->scaixa(array(),array('size' => array('M' => 5)));
			echo $this->Bl->scoluna();
				echo $this->Bl->para(array(),array(),$sobre_dinafon);
			echo $this->Bl->ecoluna();
		echo $this->Bl->ecaixa();
		
		echo $this->Bl->scaixa(array(),array('size' => array('M' => 5)));
			echo $this->Bl->scoluna();

				echo $this->Bl->h2(array(),array(),'As pessoas');
				foreach ($pessoas as $k => $pessoa)
				{
					$pessoa['id'] = $k;
					echo $this->element('pessoa',array('tipo' => 'mini_preview', 'dados' => $pessoa));
				}
				echo $this->Bl->para(array(),array(),
						array(
							$this->Bl->anchor(array(),array('url' => array('controller' => 'pessoas', 'action' => 'index')),'Conheça todas as pessoas')
						)
				);
			echo $this->Bl->ecoluna();
		echo $this->Bl->ecaixa();
	echo $this->Bl->ecaixote();
?>