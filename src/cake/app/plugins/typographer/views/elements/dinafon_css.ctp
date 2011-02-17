<?php

//@todo mudar tudo que for caixa para box (não usar replace, pois tem atributos como topoCaixa)
//@todo converir font-size e line-height pra ficar correto
$this->Decorator->rule(
		'*', array(
			'margin' => '0',
			'padding' => '0',
			'list-style' => 'none',
			'vertical-align' => 'baseline',
			'text-decoration' => 'none',
			'font-family' => '"Lucida Sans", "Bitstream Vera", sans',
			'font-size' => $u->t($standard_font_size),
			'line-height' => $u->t($lineHeight),
			'border' => 'none'
	));


$this->Decorator->rule(
		'#logo', array(
			'margin-top' => $u->t($lineHeight/2)
	));


//@todo verificar se o 12M não gera problema
//(pois ele substitui uma função que não existe mais, a
//calculaTamanhoTotal) - verificar em todo lugar que tiver:
//$hg->size(array('M'=>12))
$this->Decorator->rule(
		'.coluna_principal', array(
			'width' => $hg->size(array('M'=>12)),
			'position' => 'relative',
			'margin-left' => 'auto',
			'margin-right' => 'auto'
	));

$this->Decorator->rule(
		'div.coluna_principal .div_extrapolante', array(
			'width' => $u->t($hg->size(array('M'=>12)) + $hg->size(array('g'=>2),false)),
			'margin-left' => $hg->size(array('g'=>-1)),
			'margin-right' => $hg->size(array('g'=>-1)),
			'float' => 'left',
			'position' => 'relative'
	));

$this->Decorator->rule(
		'div.coluna_principal .div_intrapolante', array(
			'width' => $u->t($hg->size(array('M'=>12)) + $hg->size(array('g'=>-2),false)),
			'margin-left' => $hg->size(array('g' => 1)),
			'margin-right' => $hg->size(array('g' => 1)),
			'float' => 'left',
			'position' => 'relative'
	));

$this->Decorator->rule(
		'#primeiro_cabecalho', array(
			'height' => $vg->size(array('M' => 1, 'g' => 2))
	));

$this->Decorator->rule(
		'#conteudo', array(
			'background-color' => $palette['fundo_conteudo']->write(),
			'width' => 'auto'
	));

$this->Decorator->rule(
		'.caixa', array(
			'background-color' => $palette['fundo_caixotinho']->write(),
			'margin-left' => $hg->size(array('g' => 1)),
			'margin-bottom' => $vg->size(array('g' => 2)),
			'float' => 'left',
			'padding-top' => '0'
	));



$this->Decorator->rule(
		'.caixa.transparente', array(
			'background-color' => 'none',
			'margin-left' => $hg->size(array('g' => 1)),
			'margin-bottom' => '0',
			'float' => 'left'
	));

$this->Decorator->rule(
		'#conteudo .coluna .caixinha', array(
			'float' => 'left',
			'display' => 'block',
			'margin-left' => $hg->size(array('g' => 1)),
			'margin-right' => '0'
	));

$this->Decorator->rule(
		'#conteudo .coluna .caixinha_2', array(
			'float' => 'left',
			'display' => 'block',
			'margin-left' => '0',
			'margin-right' => '0'
	));


$this->Decorator->rule(
		'.noticias_pagina_principal', array(
			'float' => 'left',
			'display' => 'block',
			'margin' => '0',
			'width' => $hg->size(array('M' => 3, 'g' => 2, 'M' => 1))
	));

$this->Decorator->rule(
		'.publicacoes_pagina_principal', array(
			'float' => 'left',
			'display' => 'block',
			'margin-left' => $hg->size(array('g' => 1)),
			'width' =>  $hg->size(array('M' => 3, 'g' => 1.8, 'M' => 1))
	));


$this->Decorator->rule(
		'.larg_3M_-3i_-1m', array(
			'width' => $hg->size(array('M' => 3, 'g' => -3, 'M' => -1))
	));

$this->Decorator->rule(
		'.caixote', array(
			'margin' => '0',
			'float' => 'left'
	));

$this->Decorator->rule(
		'.espacador_vertical', array(
			'margin' => '0',
			'float' => 'left',
			'height' => $vg->size(array('g' => 1))
	));


$this->Decorator->rule(
		'.espacador_horizontal', array(
			'margin' => '0',
			'float' => 'left',
			'clear' => 'both',
			'height' => $vg->size(array('g' => 1))
	));

$this->Decorator->rule(
		'.larg_auto', array(
			'margin' => 'auto'
	));


$this->Decorator->rule(
		'p', array(
			'text-indent' => $u->t($lineHeight)
	));

$this->Decorator->rule(
		'p:first-child', array(
			'text-indent' => '0'
	));

$this->Decorator->rule(
		'.paragrafos', array(
			'margin-bottom' => $u->t($lineHeight)
	));

$this->Decorator->rule(
		'.coluna ul, .coluna ol', array(
			'margin-bottom' => $u->t($lineHeight)
	));

$this->Decorator->rule(
		'.coluna ul ul, .coluna ul ol, .coluna ol ul, .coluna ul ol', array(
			'margin-bottom' => '0'
	));

$this->Decorator->rule(
		'.coluna h1, .coluna h2, .coluna h3, .coluna h4, .coluna h5, .coluna p, .coluna ul, .coluna ol, .coluna form, .coluna span', array(
			'margin-left' => $hg->size(array('g' => 1)),
			'margin-right' => $hg->size(array('g' => 1))
	));

$this->Decorator->rule(
		'.coluna p span, .coluna h1 span,.coluna h2 span, .coluna h3 span, .coluna h4 span, .coluna h5 span', array(
			'margin-left' => 0
	));

$this->Decorator->rule(
		'coluna form', array(
			'margin-bottom' => $u->t($lineHeight)
	));

$this->Decorator->rule(
		'.coluna a, .menu_1_lateral a, .menu_lateral a:visited', array(
			'color' => $palette['texto']->write(),
			'border-bottom' => $u->t(2) . 'solid' . $palette['texto_destaque']->write()
	));

$this->Decorator->rule(
		'.coluna a:visited', array(
			'color' => $palette['texto_colorido_rebaixado']->write()
	));

$this->Decorator->rule(
		'.coluna a:hover, .coluna a:active, .menu_1_lateral a:hover, .menu_1_lateral a:active', array(
			'border-bottom' => $u->t(2) . 'solid' . $palette['principal']->write(),
			'background-color' => $palette['principal']->write()
	));

$this->Decorator->rule(
		'.coluna .texto_pequeno', array(
			'font-size' => $u->t($standard_font_size * 11/14)
	));

$this->Decorator->rule(
		'.coluna .italico', array(
			'font-style' => 'italic'
	));

$this->Decorator->rule(
		'.flutuante', array(
			'float' => 'left'
	));

$this->Decorator->rule(
		'h1, h1 *, h2, h2 *, h3, h3 *', array(
			'font-family' => 'Georgia, serif'
	));

$this->Decorator->rule(
		'h1, h1 *, h4, h4 *, h5, h5 * ', array(
			'font-weight' => '700'
	));

$this->Decorator->rule(
		'h1, h1 *', array(
			'color' => $palette['principal']->write(),
			'display' => 'block',
			'float' => 'left',
			'clear' => 'none',
			'line-height' => $u->t(30),
			'font-size' => $u->t(23)
	));

$this->Decorator->rule(
		'.coluna h1', array(
			'color' => $palette['texto']->write(),
			'display' => 'block',
			'float' => 'none',
			'clear' => 'both'
	));

$this->Decorator->rule(
		'h2, h2 *', array(
			'line-height' => $u->t(30),
			'font-size' => $u->t(23),
			'color' => $palette['texto_destaque']->write(),
			'font-weight' => '500'
	));

$this->Decorator->rule(
		'h3, h3 *', array(
			'line-height' => $u->t($lineHeight),
			'font-size' => $u->t(17),
			'font-weight' => '500'
	));

$this->Decorator->rule(
		'h4, h4 *', array(
			'line-height' => $u->t($lineHeight),
			'font-size' => $u->t($standard_font_size),
			'color' => $palette['texto_destaque']->write()
	));

$this->Decorator->rule(
		'h5, h5 *', array(
			'line-height' => $u->t($lineHeight),
			'font-size' => $u->t($standard_font_size)
	));

$this->Decorator->rule(
		'ol, ol li', array(
			'list-style-type' => 'decimal',
			'margin-left' => $u->t($lineHeight)
	));

$this->Decorator->rule(
		'.colorido, .colorido *, span.colorido a', array(
			'color' => $palette['texto_destaque']->write()
	));

$this->Decorator->rule(
		'.barra_h', array(
			'clear' => 'both',
			'width' => 'auto',
			'display' => 'block',
			'background-repeat' => 'repeat-x'
	));


$this->Decorator->rule(
		'.colorida_branco', array(
			'background-image' => "url('". $ig->url(
				array(
						'w' => '1600',
						'h' => '5',
						'iw' => '1600*4',
						'ih' => '5*4',
						'base_name' => 'barrinha_cor_fundo_cab',
						'layers' => array(
							array(
								'type' => 'aplicar_cor',
								'color' => $palette['fundo_cabecalho']
							),
							array(
								'type' => 'imagem_colorizada',
								'path' => '/img/matrizes/barrinha_vermelha_fundo_cabecalho_fundo_aplicacao.png',
								'color' => $palette['principal']
							)
						)
					)
				)
				.  "')",
			'height' => $u->t(4),
			'margin-bottom' => $vg->size(array('g' => 1))
	));


$this->Decorator->rule(
		'.colorida_branco_cinza', array(
			'background-image' => "url('". $ig->url(
				array(
						'w' => '1600',
						'h' => '4',
						'iw' => '1600*4',
						'ih' => '4*4',
						'base_name' => 'barrinha_topo',
						'layers' => array(
							array(
								'type' => 'aplicar_cor',
								'color' => $palette['fundo_cabecalho']
							),
							array(
								'type' => 'imagem_colorizada',
								'path' => '/img/matrizes/barrinha_barrao_c-principal_f1-fundo_cabecalho_f2-fundo_conteudo.png',
								'color' => $palette['fundo_conteudo']
							),
							array(
								'type' => 'imagem_colorizada',
								'path' => '/img/matrizes/barrinha_pont_c-principal_f1-fundo_cabecalho_f2-fundo_conteudo.png',
								'color' => $palette['principal']
							)
						)
					)
				)
				.  "')",
			'height' => $u->t(4),
			'margin-bottom' => $vg->size(array('g' => 0.5))
	));


$this->Decorator->rule(
		'.colorida_cinza_branco', array(
			'background-image' => "url('". $ig->url(
				array(
						'w' => '1600',
						'h' => '6',
						'iw' => '1600*4',
						'ih' => '6*4',
						'base_name' => 'barrinha_baixo',
						'layers' => array(
							array(
								'type' => 'aplicar_cor',
								'color' => $palette['fundo_cabecalho']
							),
							array(
								'type' => 'imagem_colorizada',
								'path' => '/img/matrizes/barrinha_barrao_c-principal_f1-fundo_conteudo_f2-fundo_cabecalho.png',
								'color' => $palette['fundo_conteudo']
							),
							array(
								'type' => 'imagem_colorizada',
								'path' => '/img/matrizes/barrinha_pont_c-principal_f1-fundo_conteudo_f2-fundo_cabecalho.png',
								'color' => $palette['principal']
							)
						)
					)
				)
				.  "')",
			'height' => $u->t(5)
	));


//@todo verificar se esse trecho ficando fora do Decorator funciona
$altura = 5;
$cima = floor($lineHeight - 5)/2;
$baixo = $lineHeight - 5 - $cima;


$this->Decorator->rule(
		'.cinza_branco', array(
			'height' => $u->t($altura),
			'background-image' => "url('". $ig->url(
				array(
						'w' => '1600',
						'h' => '5',
						'iw' => '1600*4',
						'ih' => '5*4',
						'base_name' => 'barrinha_c-fundo_conteudo_f-fundo_caixotinho',
						'layers' => array(
							array(
								'type' => 'aplicar_cor',
								'color' => $palette['fundo_caixotinho']
							),
							array(
								'type' => 'imagem_colorizada',
								'path' => '/img/matrizes/barrinha_c-fundo_conteudo_f-fundo_caixotinho.png',
								'color' => $palette['fundo_conteudo']
							)
						)
					)
				)
				.  "')",
			'margin-bottom' => $u->t($baixo),
			'margin-top' => $u->t($cima)
	));


$this->Decorator->rule(
		'.tracejada_cinza_branco', array(
			'background-image' => "url('". $ig->url(
				array(
						'w' => '1028',
						'h' => '3',
						'iw' => '1028*4',
						'ih' => '3*4',
						'base_name' => 'barrinha_tracejada',
						'layers' => array(
							array(
								'type' => 'aplicar_cor',
								'color' => $palette['fundo_cabecalho']
							),
							array(
								'type' => 'imagem_colorizada',
								'path' => '/img/matrizes/barrinha_tracejada_c-fundo_conteudo_f-fundo_cabecalho.png',
								'color' => $palette['fundo_conteudo']
							)
						)
					)
				)
				.  "')",
				'height' => $u->t(2),
				'margin-top' => $vg->size(array('g' => 0.5)),
				'margin-bottom' => $vg->size(array('g' => 0.5))
	));


$this->Decorator->rule(
		'.limpador', array(
			'clear' => 'both'
	));

$this->Decorator->rule(
		'.menu_0 *', array(
			'font-family' => 'Georgia, serif',
			'font-size' => $u->t($standard_font_size * 18/14),
			'line-height' => $u->t($lineHeight * 30/20)
	));

$this->Decorator->rule(
		'.menu_0', array(
			'margin-top' => $vg->size(array('M' => 1/2))
	));

$this->Decorator->rule(
		'.menu_0 a', array(
			'color' => $paleta['texto']->write()
	));

$this->Decorator->rule(
		'.menu_0 a:hover, .menu_0 a:active, .menu_0 a.selecionado', array(
			'color' => $paleta['principal']->write()
	));

$this->Decorator->rule(
		'.menu_1_lateral', array(
			'float' => 'right',
			'margin-top' => $u->t($lineHeight/3)
	));

$this->Decorator->rule(
		'.spsassd_menu *, .menu_1 *', array(
			'font-family' => 'Georgia, serif',
			'font-size' => $u->t(15)
	));

$this->Decorator->rule(
		'.spsassd_menu a, .menu_1 a', array(
			'color' => $paleta['texto']->write()
	));

$this->Decorator->rule(
		'.spsassd_menu a:hover, .menu_1 a:hover, .menu_1 a.selecionado', array(
			'color' => $paleta['texto_destaque']->write()
	));

$this->Decorator->rule(
		'.spsassd_menu a:active, .menu_1 a:active', array(
			'color' => $paleta['texto_destaque']->write()
	));

$this->Decorator->rule(
		'.input.text label, .input.textarea label, .input.password label,fieldset legend', array(
			'display' => 'block',
			'font-weight' => 'bold'
	));

$this->Decorator->rule(
		'.input.text, .input.password', array(
			'margin-bottom' => $vg->size(array('g' => 1))
	));

$this->Decorator->rule(
		'.input.text input, .input.password input, label input', array(
			'background-color' => $paleta['input_texto']->write(),
			'width' => $gh->calcTam(array('M' => 3)),
			'height' => $u->t($lineHeight),
			'line-height' => $u->t($lineHeight)
	));

$this->Decorator->rule(
		'.input.textarea', array(
			'margin-bottom' => $vg->size(array('g' => 1))
	));

$this->Decorator->rule(
		'.input.textarea textarea', array(
			'background-color' => $paleta['input_texto']->write(),
			'width' => $gh->calcTam(array('M' => 3)),
			'height' => $u->t($lineHeight*5)
	));

$this->Decorator->rule(
		'.input.radio', array(
			'margin-bottom' => $vg->size(array('g' => 1))
	));

$this->Decorator->rule(
		'.input.radio label', array(
			'height' => $u->t($lineHeight),
			'line-height' => $u->t($lineHeight)
	));

$this->Decorator->rule(
		'.input.radio input', array(
			'margin-right' => $gh->calcTam(array('g' => 0.5))
	));


$this->Decorator->rule(
		'.submit input', array(
			'width' => $gh->calcTam(array('M' => 3)),
			'height' => $u->t($lineHeight*1.5)
	));

$this->Decorator->rule(
		'.form-error', array(
			'border' => '1px solid '. $paleta['mensagem_erro']->write()
	));

$this->Decorator->rule(
		'.form-error', array(
			'color' => $paleta['mensagem_erro']->write()
	));

$this->Decorator->rule(
		'div#excecao p a', array(
			'border' => '0',
			'background-color' => '#FFFFFF'
	));

$this->Decorator->rule(
		'div#excecao p a:hover, div#excecao p a:active', array(
			'background-color' => '#FFFFFF'
	));

$this->Decorator->rule(
		'#rodape', array(
			'height' => $vg->size(array('M' => 5)),
			'background-color' => $paleta['fundo_rodape']->write()
	));


$this->Decorator->rule(
		'#rodape p, #rodape a, #rodape b, #rodape *', array(
			'line-height' => $vg->size(array('g' => 1.4)),
			'font-size' => $vg->size(array('g' => 0.9))
	));

//@todo trocar o $_SESSION['kulepona_n_atrator']
$this->Decorator->rule(
		'#atrator_rodape', array(
			'height' => $vg->size(array('M' => 5, 'g' => -2)),
			'width' => $gh->calcTam(array('M' => 7)),
			'float' => 'left',
			'background-image' => "url('". $ig->url(
				array(
						'w' => '576',
						'h' => '548',
						'base_name' => 'atrator' . $_SESSION['kulepona_n_atrator'],
						'layers' => array(
							array(
								'type' => 'aplicar_cor',
								'color' => $palette['fundo_cabecalho']
							),
							array(
								'type' => 'imagem_colorizada',
								'path' => '/img/matrizes/atrator'.$_SESSION['kulepona_n_atrator'].'.png',
								'color' => $paleta['atrator']
							)
						)
					)
				)
				.  "')",
				'background-repeat' => 'no-repeat',
				'background-position' => $gh->calcTam(array('g' => -4)) . ' ' .  $vg->size(array('M' => -2))
	));

//@todo verificar se colocar esse comando aqui é tranquilo
$atrator = rand(2,6);

$this->Decorator->rule(
		'#atrator_aleatorio', array(
			'height' => $vg->size(array('M' => 4, 'g' => -4)),
			'width' => 'auto',
			'background-image' => "url('". $ig->url(
				array(
						'w' => '576',
						'h' => '548',
						'base_name' => 'atrator' . $atrator,
						'layers' => array(
							array(
								'type' => 'aplicar_cor',
								'color' => $palette['fundo_cabecalho']
							),
							array(
								'type' => 'imagem_colorizada',
								'path' => '/img/matrizes/atrator'.$atrator.'.png',
								'color' => $paleta['atrator']
							)
						)
					)
				)
				.  "')",
				'background-repeat' => 'no-repeat',
				'background-position' => $gh->calcTam(array('g' => -1)) . ' ' .  $vg->size(array('g' => -4))
	));


$this->Decorator->rule(
		'.topo_caixa', array(
			'height' => $u->t($imagem_topo_caixas->altura_max), //seria necessario reconverter aqui no caso de se usar um layout de impressao
			'margin-bottom' => $vg->size(array('M' => 1, 'g' => 0))
	));


?>
