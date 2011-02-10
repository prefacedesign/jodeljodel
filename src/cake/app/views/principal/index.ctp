<?php
	echo $kulepona->caixoteInicio(array('tamanho' => array('qM' => 7)));
		echo $kulepona->caixaInicio(array('tamanho' => array('qM' => 7)));
			echo $kulepona->colunaInicio();
			
				echo $kulepona->h2('Eventos');
				
				echo $kulepona->h4('June 7 through June 11');
				echo $kulepona->h5($kulepona->link('São Paulo School of Advanced Studies in Speech Dynamics', array('plugin' => 'spsassd', 'controller' => 'spsassd')));
				echo $kulepona->para('The São Paulo School of Advanced Studies in Speech Dynamics (SPSASSD) is a 5-day event designed to foster speech research in Brazil by promoting dialogue between international and national experts and offering opportunities to talented students from all over the world.');
			
				echo $kulepona->limpador();
				
				echo $kulepona->iTag('div', array('class' => 'noticias_pagina_principal'));
					if (isset($noticias))
					{	
						echo $kulepona->h2('Notícias');
						echo $this->element('noticia', array ('tipo' => 'preview', 'dados' => $noticias[0]));
						
						unset($noticias[0]);
						
						foreach($noticias as $noticia)
						{
							echo $this->element('noticia', array ('tipo' => 'linha_link', 'dados' => $noticia));
						}
						echo $kulepona->tag('br');
						echo $kulepona->tag('span',array(), array('escape' => true), $kulepona->link('Ver mais notícias', array('controller' => 'noticias')));
						echo $kulepona->tag('br');
						echo $kulepona->tag('br');
					}
				echo $kulepona->fTag('div');
				
				echo $kulepona->iTag('div', array('class' => 'publicacoes_pagina_principal'));
					if (isset($publicacoes))
					{	
						echo $kulepona->h2('Publicações');
						echo $this->element('publicacao', array ('tipo' => 'preview', 'dados' => $publicacoes[0]));
						
						echo $kulepona->tag('br');
						echo $kulepona->tag('span',array(), array('escape' => true), $kulepona->link('Ver mais publicações do Dinafon', array('controller' => 'publicacoes')));
						echo $kulepona->tag('br');
						echo $kulepona->tag('br');
					}
				echo $kulepona->fTag('div');
			echo $kulepona->colunaFim();
		echo $kulepona->caixaFim();
	echo $kulepona->caixoteFim();
	
	echo $kulepona->caixoteInicio(array('tamanho' => array('qM' => 5)));
		echo $kulepona->caixaInicio(array('tamanho' => array('qM' => 5)));
			echo $kulepona->colunaInicio();
			
				echo $kulepona->h2('O grupo de pesquisa');
				echo $kulepona->para(array($sobre_dinafon_pequeno));
				echo $kulepona->tag('span',array(), array('escape' => true), $kulepona->link('Mais sobre o Dinafon', array('controller' => 'principal', 'action' => 'sobre')));
				echo $kulepona->iTag('div',array('id' => 'atrator_aleatorio'));
				echo $kulepona->fTag('div');
				
			echo $kulepona->colunaFim();
		echo $kulepona->caixaFim();
	echo $kulepona->caixoteFim();
?>