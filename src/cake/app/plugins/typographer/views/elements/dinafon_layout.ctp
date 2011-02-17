<?php
	echo $bl->sdiv(array('id'=>'cabecalho'));
		if ($this->params['action'] != 'admin_index')
		{
			echo $bl->sdiv(array(
						'id'=>'cabecalho',
						'class' => 'centralizado coluna_principal'));
				//@todo verificar se pode continuar chamando tamanho
				echo $bl->scaixa(array(),array('size' => array('M' => 4), 'tipo' => 'transparente'));
						echo $ig->url(
							array(
								'w' => '239',
								'h' => '79',
								'iw' => '239*8',
								'ih' => '79*8',
								'base_name' => 'l_din_'.$session->read('kulepona_n_logo'),
								'layers' => array(
									array(
										'type' => 'aplicar_cor',
										'color' => $palette['fundo_cabecalho']
									),
									array(
										'type' => 'imagem',
										'path' => '/img/matrizes/logo_dinafon_logotipo.png'
									),
									array(
										'type' => 'imagem_colorizada',
										'path' => '/img/matrizes/logo_dinafon_simbolo_'.$session->read('kulepona_n_logo').'.png',
										'color' => $palette['principal']
									)
								)
							)

						);

				echo $bl->ecaixa();
				echo $this->element('menu_site', array('nivel' => 0));

			echo $bl->ediv();

			if (isset($this->params['plugin']) && in_array($this->params['plugin'], array('spsassd','dinafon_iv')))
			{
				switch($this->params['plugin'])
				{
					case 'spsassd':
						$nome = 'São Paulo School of Advanced Studies in Speech Dynamics';
						$menu = $this->element('menu', array('plugin' => 'spsassd', 'selecionado' => 'index'));
					break;

					case 'dinafon_iv':
						$nome = 'IV Encontro do Grupo de Pesquisa Dinafon';
						$menu = $this->element('menu', array('plugin' => 'dinafon_iv', 'selecionado' => 'index'));
					break;
				}
				
				echo $bl->barraHorizontal(array('class' => array('colorida_branco')));
				
				echo $bl->div(
					array(
						'class' => array('centralizado','coluna_principal')
					),
					array(),
					$bl->div(
						array('class' => array('div_intrapolante')),
						array(),
						$bl->h1(
							array('style' => 'color: black;'),
							array(),$nome
						)
					). $bl->floatBreak()
				);

				echo $bl->barraHorizontal(array('class' => array('tracejada_cinza_branco')));

				echo $bl->div(
					array(
						'class' => array('centralizado coluna_principal')
					),
					array(),
					$bl->div(
						array('class' => array('div_intrapolante')),
						array(),
						$menu
					). $bl->floatBreak()
				);
			}
			else
			{
				if (isset($onde_estamos[0])) //se existe o sub-nível 2
				{
					echo $this->element('menu_site', array('nivel' => 1));
				}
			}
		}
		else
		{
			echo $bl->sdiv(
				array(
					'class' => array(
						'centralizado',
						'coluna_principal'
					)
				)
			);

				echo $bl->sdiv(array('class' => array('div_intrapolante')));

					echo $bl->h1(array(),array(),'SPSASSD &ndash; Edição dos textos');

				echo $bl->ediv();
				echo $bl->floatBreak();
					
			echo $bl->ediv();
			
		}

	echo $bl->ediv();

	echo $bl->barraHorizontal(array('class' => array('colorida_branco_cinza')));

	echo $bl->sdiv(array('id' => array('conteudo')));
		//@todo verificar se esse g => 2 está correto, se não precisa ir em tamanho
		echo $bl->floatBreak(array(),array('g' => 2));

		echo $bl->sdiv(array('class' => array('centralizado','coluna_principal')));
			echo $bl->sdiv(array('class' => array('div_intrapolante')));
				echo $content_for_layout;
				echo $bl->floatBreak();
			echo $bl->ediv();
			echo $bl->floatBreak();
			

			echo $bl->espacadorVertical(array(),array('size' => array('g' => 2)));
			
		echo $bl->ediv();
		echo $bl->floatBreak();

	echo $bl->ediv();
	
	echo $bl->barraHorizontal(array('class' => array('colorida_cinza_branco')));

	echo $bl->sdiv(array('class' => array('centralizado','coluna_principal'), 'id' => 'rodape'));
		echo $bl->sdiv(array('class' => array('div_intrapolante')));
			echo $bl->div(array('id' => 'atrator_rodape'));

				echo $bl->scoluna(array(),array('size' => array('M' => 3)));
					echo $bl->espacadorHorizontal(array(),array('size' => array('g' => 1)));

					echo $bl->para(
						array(),
						array(),
						array(
							'Dinafon stands for Dinâmica Fônica, speech dynamics, and names a group of phonologists/phoneticians led by Eleonora Albano.<br/>'
							. $html->link('LAFAPE', 'http://www.lafape.iel.unicamp.br') . ' &ndash; '
							. $html->link('IEL', 'http://www.iel.unicamp.br') . ' &ndash; '
							. $html->link('Unicamp', 'http://www.unicamp.br')
						)
					);

					echo $bl->para(
						array(),
						array(),
						array(
							  '<b>e-mail</b>&emsp;albano@unicamp.br <br/>'
							. '<b>phone</b>&emsp;+55 19 35211532 <br/>'
							. '<b>address</b>&emsp;'
							. '<br/>LAFAPE, IEL/UNICAMP <br/>'
							. 'Rua Sérgio Buarque de Holanda, 571 <br/>'
							. 'Cidade Universitária<br/>'
							. 'Campinas/SP &ndash; Brazil <br/>'
							. 'CEP 13.083&ndash;859'
						)
					);

					echo $bl->para(
						array(),
						array(),
						array(
							  'Layout e programação por ' . $html->link('Preface&nbsp;Design', 'http://preface.com.br', array(), null, false)
						)
					);
				echo $bl->ecoluna();

				echo $bl->espacadorVertical(array(),array('size' => array('g' => 1)));
				echo $bl->sdiv(array('id' => 'excecao'));

					echo $bl->scoluna(array(),array('size' => array('M' => 1)));
						echo $bl->espacadorHorizontal(array(),array('size' => array('qi' => 1)));
						//@todo verificar se o $bl->link funciona
						
						echo $bl->para(
							array(),
							array(),
							array(
								$html->link($bl->imagem(array(),array(),'/img/layout/unicamp.gif'), 'http://www.unicamp.br', array(), null, false)
						));
					echo $bl->ecoluna();
			echo $bl->ediv();

		echo $bl->ediv();
	echo $bl->ediv();

	$this->Html->scriptBlock("
		var gaJsHost = ((\"https:\" == document.location.protocol) ? \"https://ssl.\" : \"http://www.\");
		document.write(unescape(\"%3Cscript src='\" + gaJsHost + \"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E\"));
	");
	$this->Html->scriptBlock("
		try {
		var pageTracker = _gat._getTracker(\"UA-1711136-10\");
		pageTracker._trackPageview();
		} catch(err) {}"
	);
