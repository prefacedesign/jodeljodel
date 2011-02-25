<?php
	echo $this->Bl->scaixote(array(),array('size' => array('M' => 7)));
		echo $this->Bl->scaixa(array(),array('size' => array('M' => 7)));
			echo $this->Bl->scoluna();
				echo $this->Bl->h2(array(),array(),'Eventos');

				echo $this->Bl->h4(array(),array(),'June 7 through June 11');

				echo $this->Bl->h5(array(),array(),
					$this->Bl->anchor(array(),array('url' => array('plugin' => 'spsassd', 'controller' => 'spsassd')),'São Paulo School of Advanced Studies in Speech Dynamics' )
				);

				echo $this->Bl->para(array(),array(),array('The São Paulo School of Advanced Studies in Speech Dynamics (SPSASSD) is a 5-day event designed to foster speech research in Brazil by promoting dialogue between international and national experts and offering opportunities to talented students from all over the world.'));
				
				echo $this->Bl->floatBreak();

				echo $this->Bl->sdiv(array('class' => 'noticias_pagina_principal'));
					if (isset($noticias))
					{
						echo $this->Bl->h2(array(),array(),'Notícias');
						echo $this->element('noticia', array ('tipo' => 'preview', 'dados' => $noticias[0]));

						unset($noticias[0]);

						foreach($noticias as $noticia)
						{
							echo $this->element('noticia', array ('tipo' => 'linha_link', 'dados' => $noticia));
						}
						echo $this->Bl->brDry();
						echo $this->Bl->span(array(), array('escape' => true), $this->Bl->anchor(array(),array('url' => array('controller' => 'noticias')),'Ver mais notícias'));
						echo $this->Bl->brDry();
						echo $this->Bl->brDry();
					}
				echo $this->Bl->ediv();

				echo $this->Bl->sdiv(array('class' => 'publicacoes_pagina_principal'));
					if (isset($publicacoes))
					{
						echo $this->Bl->h2(array(),array(),'Publicações');
						echo $this->element('publicacao', array ('tipo' => 'preview', 'dados' => $publicacoes[0]));

						echo $this->Bl->brDry();
						echo $this->Bl->span(array(), array('escape' => true), $this->Bl->anchor(array(),array('url' => array('controller' => 'publicacoes')),'Ver mais publicações do Dinafon'));
						echo $this->Bl->brDry();
						echo $this->Bl->brDry();
					}
				echo $this->Bl->ediv();
			echo $this->Bl->ecoluna();
		echo $this->Bl->ecaixa();
	echo $this->Bl->ecaixote();

	echo $this->Bl->scaixote(array(),array('size' => array('M' => 5)));
		echo $this->Bl->scaixa(array(),array('size' => array('M' => 5)));
			echo $this->Bl->scoluna();

				echo $this->Bl->h2(array(),array(),'O grupo de pesquisa');

				echo $this->Bl->para(array(),array(),array($sobre_dinafon_pequeno));

				echo $this->Bl->span(array(), array('escape' => true), $this->Bl->anchor(array(),array('url' => array('controller' => 'principal', 'action' => 'about')), 'Mais sobre o Dinafon'));
				echo $this->Bl->sdiv(array('id' => 'atrator_aleatorio'));
				echo $this->Bl->ediv();

			echo $this->Bl->ecoluna();
		echo $this->Bl->ecaixa();
	echo $this->Bl->ecaixote();
?>