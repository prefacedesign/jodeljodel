<?php
//este é o layout do conexoes, um element na verdade.

echo $h->iDiv(array('id' => 'cabecalho', 'class' => array('coluna_principal')));
	echo $h->iDiv(array('id' => 'cabecalho_do_cabecalho'));		
		echo $h->iCaixote(array(), array('tam' => array('qM' => 11, 'qi' => 0)));
			echo $h->linque(array('class' => 'link_pagina_principal'), array('url' => array('controller' => 'principal', 'action' => 'index')), ' ');
		echo $h->fCaixote();
		echo $h->iCaixa(array('class' => 'assinatura_ibrasotope'), array('tam' => array('qM' => 1, 'qi' => -1)));
			echo $h->iP();
				echo 'Evento organizado por ' 
					. $h->linque(array(), array('url' => 'http://ibrasotope.com.br', 'escape' => true),
						$h->img(array('src' => $ig->url(
									array(
										'w' => $gh->calcTam(array('qi' => 7.3125)),
										'h' => $gv->calcTam(array('qi' => 1.8000)),
										'wi' => 520,
										'hi' => 128,
										'nome_base' => 'logo_ibrasotope',
										'camadas' => array(
											array(
												'tipo' => 'aplicar_cor', 
												'cor' => $paleta['cinza']
											),
											array(
												'tipo' =>	'imagem',
												'caminho' => '/img/matrizes/logo_ibrasotope.png'
											)
										)
									)
								)
							)
						)
					); 
			echo $h->fP();
		echo $h->fCaixa();
	echo $h->fDiv();
	
	if (!isset($peca_escolhida))
		echo $h->iDiv(array('id' => 'menu'));
	else
		echo $h->iDiv(array('id' => 'menu', 'class' => 'reduzido'));
		foreach($pecas as $k => $peca_atual)
		{
			$url = array(
				'controller' => 'pecas',
				'action' => 'peca',
				$k
			);
			
			if (isset($pagina))
				$url[] = $pagina;
			
			$classes = array(
				'peca_' . $k
			);
			
			if (isset($peca_escolhida) && $peca_escolhida == $k)
				$classes[] = 'selecionado';
		
			echo $h->linque(
				array(
					'class' => $classes,
					'alt' => $peca_atual['nome'] . ' por ' . $peca_atual['artista']
				),
				array(
					'url' => $url
				), ' ');
		}
	echo $h->fDiv();
echo $h->fDiv();

echo $h->limpador();

echo $h->iDiv(array('id' => 'fundo_conteudo'));
	echo $h->iDiv(array('id' => 'conteudo', 'class' => array('coluna_principal')));
		echo $content_for_layout;
		echo $h->limpador(array(),array('altura' => array('qi' => 6)));
	echo $h->fDiv();
echo $h->fDiv();


echo $h->iDiv(array('id' => 'fundo_rodape'));
	echo $h->iDiv(array('id' => 'imagem_rodape', 'class' => array('coluna_principal')));
		echo ' ';
	echo $h->fDiv();
	echo $h->iDiv(array('id' => 'rodape_do_rodape', 'class' => array('coluna_principal')));
		echo $h->iCaixote(array('class' => 'apoio'), array('tam' => array('qM' => 9, 'qi' => 0)));
			echo $h->iCaixa(array(), array('tam' => array('qM' => 2, 'qi' => -1)));
				echo $h->h3Seco('apoio');
				//echo $h->linque(array(), array('url' => 'http://www.mobile.com.br', 'escape' => 'true'),
				echo $h->img(
					array(
						'src' => $ig->url(
							array(
								'w' => $gh->calcTam(array('qi' => 13.05)),
								'h' => $gv->calcTam(array('qi' => 3.938)),
								'wi' => 928,
								'hi' => 280,
								'nome_base' => 'logo_mobile',
								'camadas' => array(
									array(
										'tipo' => 'aplicar_cor', 
										'cor' => $paleta['cinza']
									),
									array(
										'tipo' =>	'imagem',
										'caminho' => '/img/matrizes/logo_mobile.png'
									)
								)
							)
						)
					)
				);
				echo $h->linque(array(), array('url' => 'http://www.fapesp.br', 'escape' => 'true'),
					$h->img(
						array(
							'src' => $ig->url(
								array(
									'w' => $gh->calcTam(array('qi' => 12.713)),
									'h' => $gv->calcTam(array('qi' => 2.7000)),
									'wi' => 904,
									'hi' => 192,
									'nome_base' => 'logo_fapesp',
									'camadas' => array(
										array(
											'tipo' => 'aplicar_cor', 
											'cor' => $paleta['cinza']
										),
										array(
											'tipo' =>	'imagem',
											'caminho' => '/img/matrizes/logo_fapesp.png'
										)
									)
								)
							)
						)
					)
				);
			echo $h->fCaixa();
			echo $h->iCaixa(array(), array('tam' => array('qM' => 3, 'qi' => -1)));
				echo $h->h3Seco('co-patrocínio');
				echo $h->linque(array(), array('url' => 'http://ccjuve.prefeitura.sp.gov.br/', 'escape' => 'true'),
					$h->img(
						array(
							'src' => $ig->url(
								array(
									'w' => $gh->calcTam(array('qi' => 6.750)),
									'h' => $gv->calcTam(array('qi' => 9.000)),
									'wi' => 657,
									'hi' => 882,
									'nome_base' => 'logo_ccj',
									'camadas' => array(
										array(
											'tipo' => 'aplicar_cor', 
											'cor' => $paleta['cinza']
										),
										array(
											'tipo' =>	'imagem',
											'caminho' => '/img/matrizes/logo_ccj.png'
										)
									)
								)
							)
						)
					)
				);
				echo $h->linque(array(), array('url' => 'http://www.capital.sp.gov.br/', 'escape' => 'true'),
					$h->img(
						array(
							'src' => $ig->url(
								array(
									'w' => $gh->calcTam(array('qi' => 10.463)),
									'h' => $gv->calcTam(array('qi' =>  9.563)),
									'wi' => 744,
									'hi' => 680,
									'nome_base' => 'logo_prefeitura',
									'camadas' => array(
										array(
											'tipo' => 'aplicar_cor', 
											'cor' => $paleta['cinza']
										),
										array(
											'tipo' =>	'imagem',
											'caminho' => '/img/matrizes/logo_prefeitura.png'
										)
									)
								)
							)
						)
					)
				);
			echo $h->fCaixa();
		echo $h->fCaixote();
		echo $h->iCaixa(array('class' => 'creditos'), array('tam' => array('qM' => 3, 'qi' => -1)));
			echo $h->iP();
				echo 'Site e material de divulgação desenhados e implementados por '
				   . $h->linque(array(), array('url' => 'http://preface.com.br'), 'Preface Design'). '.';
			echo $h->fP();
		echo $h->fCaixa();
	echo $h->fDiv();
echo $h->fDiv();



?>
