<?php //aqui vão as regras de CSS 
	
	$pintor->regra(
		'.caixote', 
		array(
			'float' => 'left'
		)
	);
	
	$pintor->regra(
		'.caixa',
		array(
			'float' => 'left',
			//'background-color' => '#daf',
			'margin-left' => $gh->calcTam(array('qi' => 1))
		)
	);
	
	$pintor->regra(
		'.limpador', 
		array(
			'clear' => 'both'
		)
	);
	
	$pintor->regra(
		'*',
		array(
			'border' => 'none',
			'margin' => '0',
			'padding' => '0',
			'text-decoration' => 'none',
			'font-family' => 'Georgia, Cambria, FreeSerif, serif'
		)
	);
	
	$pintor->regra(
		'body',
		array(
			'background-color' => $paleta['fundo']->escreveCor(),
			'font-size' => $u->t($entrelinha * 13/18),
			'line-height' => $u->t($entrelinha),
			'color' => $paleta['texto']->escreveCor()			
		)
	);
	
	/*$pintor->regra(
		'#conteudo *',
		array(
			'color' => $paleta['texto']->escreveCor()
		)
	);*/
	
	$pintor->regra(
		'a',
		array(
			'cursor' => 'pointer'
		)
	);
	
	/*$pintor->regra(
		'body',
	);*/
	$pintor->regra(
		'#conteudo',
		array(
			'background-position' => $gh->calcTam(array('qM' => 7, 'qi' => 1)) .  ' ' . $gv->calcTam(array('qM' => 1, 'qi' =>rand(2,25))),
			'background-repeat' => 'no-repeat',
			'background-image' => "url('". $ig->url(
				array(
						'w' => $gh->calcTam(array('qM' => 3, 'qi' => -1)),
						'h' => $gv->calcTam(array('qM' => 3, 'qi' => -1)),
						'wi' => 695,
						'hi' => 695,
						'nome_base' => 'bola_no_fundo',
						'camadas' => array(
							array(
								'tipo' => 'aplicar_cor', 
								'cor' => $paleta['fundo']
							),
							array(
								'tipo' =>	'imagem_colorizada',
								'caminho' => '/img/matrizes/fundo_bola.png',
								'cor' => $paleta['amarelo']
							)
						)
					)
				)	
				.  "')"
		)
	);
	
	$pintor->regra(
		'#conteudo h2',
		array(
			'font-size' => $u->t($entrelinha * 25/18),
			'font-variant' => 'small-caps',
			'font-weight' => '500',
			'font-style' => 'italic',
			'letter-spacing' => '0.15ex',
			'margin-top' => $u->t($entrelinha * 2),
			'margin-bottom' => $u->t($entrelinha * 1)		
		)
	);
	
	$pintor->regra(
		'#conteudo h2 small',
		array(
			'font-size' => $u->t($entrelinha * 13/18),
			'font-variant' => 'normal',
			'font-weight' => '700',
			'font-style' => 'italic',
			'letter-spacing' => '0',
			'line-height' => $u->t($entrelinha * 7/4),
		)
	);
	
	$pintor->regra(
		'.fluxo .paragrafos',
		array(
			'margin-bottom' => $u->t($entrelinha * 1)		
		)
	);
	
	$pintor->regra(
		'.gadget',
		array(
			'margin-bottom' => $u->t($entrelinha * 1)
		)
	);
	
	$pintor->regra(
		'.audio',
		array(
			'margin-bottom' => $u->t($entrelinha * 1)
		)
	);
	
	$pintor->regra(
		'.link_arquivo',
		array(
			'margin-bottom' => $u->t($entrelinha * 1),
			'font-style' => 'italic'
		)
	);
	
	$pintor->regra(
		'.borda_baixo',
		array(
			'border-bottom-style' => 'solid',
			'border-width' => $u->t(1)
		)
	);
	
	$pintor->regra(
		'#conteudo h2.titulo_da_peca',
		array(
			'margin-bottom' =>  $u->t($entrelinha * 0.3)
		)
	);
	
	$pintor->regra(
		'.menu_paginas',
		array(
			'font-size' => $u->t($entrelinha * 16/18),
			'margin-top' => $u->t($entrelinha * 1),
			'display' => 'block'			
		)
	);
	
	$pintor->regra(
		'.menu_paginas a, .menu_paginas span',
		array(
			'font-style' => 'italic'
		)
	);
	
	$pintor->regra(
		'.menu_paginas .selecionado',
		array(
			'font-weight' => '700'
		)
	);
	
	$pintor->regra(
		'#conteudo h3, #rodape_do_rodape h3',
		array(
			'font-size' => $u->t($entrelinha * 18/18),
			'font-variant' => 'small-caps',
			'font-weight' => '500',
			'font-style' => 'italic',
			'letter-spacing' => '0.13ex',
			'margin-top' => $u->t($entrelinha * 1.5),
			'margin-bottom' => $u->t($entrelinha * 0.5)			
		)
	);
	
	$pintor->regra(
		'#conteudo h4',
		array(
			'font-size' => $u->t($entrelinha * 13/18),
			'font-weight' => '700',
			'margin' => 0
		)
	);
	
	$pintor->regra(
		'#conteudo p:first-child',
		array(
			'text-indent' => '0'
		)
	);
	
	$pintor->regra(
		'#conteudo p',
		array(
			'text-indent' => $u->t($entrelinha)
		)
	);
	
	$pintor->regra(
		'#conteudo img',
		array(
			'border-style' => 'solid',
			'border-width' => $u->t(1),
			'border-color' => $paleta['azul']->escreveCor(),
			'margin-bottom' => $u->t($entrelinha * 1/2)
		)
	);
	
	$pintor->regra(
		'#conteudo a, #rodape_do_rodape .creditos a',
		array(
			'border-bottom-style' => 'solid',
			'border-width' => $u->t(1),
			'border-color' => $paleta['texto']->escreveCor(),
			'color' => $paleta['texto']->escreveCor()
		)
	);
	
	$pintor->regra(
		'#conteudo a:hover, #conteudo a:active, #rodape_do_rodape .creditos a:hover, #rodape_do_rodape .creditos a:active',
		array(
			'border-bottom-style' => 'solid',
			'background-color' => $paleta['amarelo']->escreveCor()
		)
	);
	
	$pintor->regra(
		'#conteudo a.caps_italico',
		array (
			'font-style' => 'italic',
			'font-variant' => 'small-caps',
			'letter-spacing' => '0.11ex'
		)
	);
	
	$pintor->regra(
		'#conteudo a:visited',
		array(
			'color' => $paleta['cinza_escuro']->escreveCor()
		)
	);
	
	$pintor->regra(
		'#conteudo a.link_img',
		array(
			'border-bottom-style' => 'none',
			'border-width' => 0
		)
	);
	
	$pintor->regra(
		'#conteudo a.link_img:hover, #conteudo a.link_img:active',
		array(
			'background' => 'transparent'
		)
	);
	
	$pintor->regra(
		'.coluna_principal',
		array(
			'margin-left' => 'auto',
			'margin-right' => 'auto',
			'position' => 'relative',
			'width' => $gh->calcTam(array('qM' => 12, 'qi' => 1))
		)
	);
	
	$largura = $gh->calcTam(array('qM' => 12, 'qi' => 1));
	$altura  = $gv->calcTam(array('qM' =>  1, 'qi' => 0));	
	$pintor->regra(
		'#cabecalho_do_cabecalho',
		array (
			'height' => $altura,		
			'width' => $largura,
			'margin-bottom' => $gv->calcTam(array('qi' => 1)),
			'background-image' => "url('". $ig->url(
				array(
						'w' => $largura,
						'h' => $altura,
						'wi' => 3876,
						'hi' => 320,
						'nome_base' => 'cabecalho_do_cabecalho_fundo_',
						'camadas' => array(
							array(
								'tipo' => 'aplicar_cor', 
								'cor' => $paleta['fundo']
							),
							array(
								'tipo' =>	'imagem_colorizada',
								'caminho' => '/img/matrizes/cabecalho_fundo_cinza.png',
								'cor' => $paleta['cinza']
							),
							array(
								'tipo' =>	'imagem_colorizada',
								'caminho' => '/img/matrizes/cabecalho_fundo_azul.png',
								'cor' => $paleta['azul']
							),
							array(
								'tipo' =>	'imagem_colorizada',
								'caminho' => '/img/matrizes/cabecalho_texto.png',
								'cor' => $paleta['texto']
							)
						)
					)
				)	
				.  "')"
		)
	);
	
	$largura = $gh->calcTam(array('qM' => 12, 'qi' => 1));
	$altura  = $gv->calcTam(array('qM' =>  1, 'qi' => 0));	
	$pintor->regra(
		'#imagem_rodape',
		array (
			'height' => $altura,		
			'width' => $largura,
			'margin-bottom' => $gv->calcTam(array('qi' => 1)),
			'background-image' => "url('". $ig->url(
				array(
						'w' => $largura,
						'h' => $altura,
						'wi' => 3876,
						'hi' => 320,
						'nome_base' => 'rodape_',
						'camadas' => array(
							array(
								'tipo' => 'aplicar_cor', 
								'cor' => $paleta['fundo']
							),
							array(
								'tipo' =>	'imagem_colorizada',
								'caminho' => '/img/matrizes/rodape_fundo_cinza.png',
								'cor' => $paleta['cinza']
							),
							array(
								'tipo' =>	'imagem_colorizada',
								'caminho' => '/img/matrizes/rodape_fundo_azul.png',
								'cor' => $paleta['azul']
							)
						)
					)
				)	
				.  "')"
		)
	);
	
	
	
	$altura  = $gv->calcTam(array('qM' =>  1, 'qi' => 0));
	$pintor->regra(
		'#rodape_do_rodape',
		array(
			'width' => $gh->calcTam(array('qM' => 12, 'qi' => 1)),
			'height' => $gv->calcTam(array('qM' => 3, 'qi' => 0)),
			'background-color' => $paleta['cinza']->escreveCor()
		)
	);
	
	$pintor->regra(
		'#fundo_conteudo',
		array(
			'width' => 'auto',
			'position' => 'relative'
		)
	);
	
	$pintor->regra(
		'#menu',
		array(
			'background-color' => $paleta['cinza']->escreveCor(),
			'position' => 'relative',
			'float' => 'left',
			'width' => $gh->calcTam(array('qM' => 12, 'qi' => 1)),
			'margin-bottom' => $gv->calcTam(array('qi' => 1))
		)
	);
		
	$largura = $gh->calcTam(array('qM' => 2, 'qi' => -1), false);
	$altura  = $gv->calcTam(array('qM' => 2, 'qi' => -1), false);
	$altura_peq  = $gv->calcTam(array('qi' => 3.3333), false);	
	$pintor->regra(
		'#menu a',
		array(
			'margin-left' => $gh->calcTam(array('qM' => 0, 'qi' => 1)),
			'display' => 'block',
			'float' => 'left',
			'height' => $u->t($altura),
			'width' => $u->t($largura)
		)
	);
	
	$pintor->regra(
		'#menu a:hover, #menu a:active, #menu a.selecionado',
		array(
			'background-position' => '0 ' . $u->t($altura)
		)
	);
	
	$pintor->regra(
		'#menu.reduzido a',
		array(
			'margin-left' => $gh->calcTam(array('qM' => 0, 'qi' => 1)),
			'display' => 'block',
			'float' => 'left',
			'height' => $u->t($altura_peq),
			'width' => $u->t($largura),
			'background-position' => '0 ' . $u->t(-($altura - $altura_peq) + 1)
		)
	);
	
	$pintor->regra(
		'#menu.reduzido a:hover, #menu.reduzido a:active, #menu.reduzido a.selecionado',
		array(
			'background-position' => '0 ' . $u->t(-($altura * 2 - $altura_peq) + 1)
		)
	);
	
	$pintor->regra(
		'.coluna_direita',
		array(
			'border-left-style' => 'dotted',
			'border-left-width' => $u->t(1),
			'margin-top' => $u->t(round($entrelinha * 1))
		)
	);
	
	$pintor->regra(
		'#conteudo .coluna_direita h3:first-child',
		array(
			'margin-top' => $u->t(round($entrelinha * 1))
		)
	);
		
	
	$largura_original = 1208;
	$altura_original = $largura_original;
	
	for ($i = 1; $i <= 6; $i++)
	{
		$pintor->regra(
			'#menu a.peca_'.$i,
			array(
				'background-image' => "url('". $ig->url(
					array(
							'w' => $largura,
							'h' => $altura * 2,
							'wi' => $largura_original,
							'hi' => $altura_original * 2,
							'nome_base' => 'menu_peca_'.$i,
							'camadas' => array(
								array(
									'tipo' => 'aplicar_cor', 
									'cor' => $paleta['cinza_escuro'],
									'posicao' => array('h' => $altura_original)
								),
								array(
									'tipo' =>	'imagem_colorizada',
									'caminho' => '/img/matrizes/menu_peca_'.$i.'_autor.png',
									'cor' => $paleta['fundo']
								),
								array(
									'tipo' =>	'imagem_colorizada',
									'caminho' => '/img/matrizes/menu_peca_'.$i.'_nome.png',
									'cor' => $paleta['amarelo']
								),
								array(
									'tipo' => 'aplicar_cor', 
									'cor' => $paleta['amarelo'],
									'posicao' => array('y' => $altura_original, 'h' => $altura_original)
								),
								array(
									'tipo' =>	'imagem_colorizada',
									'caminho' => '/img/matrizes/menu_peca_'.$i.'_autor.png',
									'cor' => $paleta['texto'],
									'posicao' => array('y' => $altura_original)
								),
								array(
									'tipo' =>	'imagem_colorizada',
									'caminho' => '/img/matrizes/menu_peca_'.$i.'_nome.png',
									'cor' => $paleta['cinza_escuro'],
									'posicao' => array('y' => $altura_original)
								)
							)
						)
					)	
					.  "')"
			
			)		
		);
	}
	
	
	$pintor->regra(
		'div.prog_hora',
		array(
			'text-align' => 'right'
		)
	);
	
	$pintor->regra(
		'div.dia, div.ficha_tecnica',
		array(
			'border-bottom-width' => $u->t(1),
			'border-bottom-style' => 'dotted',
			'padding-bottom' => $u->t(round($entrelinha * 1/3)),
			'padding-top' => $u->t(round($entrelinha * 1/3))
		)
	);
	
	$pintor->regra(
		'div.dia.primeiro, div.ficha_tecnica.primeiro',
		array(
			'margin-top' => $u->t($entrelinha * 1/2),
			'border-top-style' => 'solid',
			'border-top-width' => $u->t(1),
		)
	);
	
	$pintor->regra(
		'.programacao div div',
		array(
			'border' => 'none'
		)
	);
	
	$pintor->regra(
		'.programacao',
		array(
			'background-color' => $paleta['fundo']->escreveCor()
		)
	);
	
	$pintor->regra(
		'#cabecalho_do_cabecalho a.link_pagina_principal',
		array(
			'width' => $gh->calcTam(array('qM' => 6)),
			'height' => $gv->calcTam(array('qM' => 1, 'qi' => 0)),
			'display' => 'block'
		)
	);
	
	$pintor->regra(
		'#cabecalho_do_cabecalho .assinatura_ibrasotope p',
		array(
			'font-size' => $u->t($entrelinha * 9/18),
			'margin-top' => $u->t($entrelinha * 1/2)
		)
	);
	
	$pintor->regra(
		'#cabecalho_do_cabecalho .assinatura_ibrasotope p img',
		array(
			'font-size' => $u->t($entrelinha * 9/18),
			'margin-top' => $u->t($entrelinha * 1/4)
		)
	);
	
	
	$pintor->regra(
		'#rodape_do_rodape img',
		array(
			'margin-bottom' => $gv->calcTam(array('qi' => 1)),
			'margin-right' => $gh->calcTam(array('qi' => 1))
		)
	);
	
	$pintor->regra(
		'#rodape_do_rodape .creditos',
		array(
			'margin-top' =>  $gv->calcTam(array('qi' => 4))
		)
	);
	
	$pintor->regra(
		'#rodape_do_rodape .creditos p',
		array(
			'margin-bottom' =>  $u->t($entrelinha * 1)
		)
	);
	
	$pintor->regra(
		'.italico',
		array(
			'font-style' => 'italic'
		)
	);
	
?>
