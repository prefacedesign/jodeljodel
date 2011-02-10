<?php

//@todo converir font-size e line-height pra ficar correto
$this->Decorator->rule(
		'*', array(
			'margin' => '0',
			'padding' => '0',
			'list-style' => 'none',
			'vertical-align' => 'baseline',
			'text-decoration' => 'none',
			'font-family' => '"Lucida Sans", "Bitstream Vera", sans',
			'font-size' => $u->t($tam_fonte_padrao),
			'line-height' => $u->t($entrelinha),
			'border' => 'none'
	));


$this->Decorator->rule(
		'#logo', array(
			'margin-top' => $u->t($entrelinha/2)
	));


$this->Decorator->rule(
		'.coluna_principal', array(
			'width' => $gh->calculaTamanhoTotal(),
			'position' => 'relative',
			'margin-left' => 'auto',
			'margin-right' => 'auto'
	));

$this->Decorator->rule(
		'div.coluna_principal .div_extrapolante', array(
			'width' => $u->t($gh->calculaTamanhoTotal(false) + $gh->calcTam(array('qi' => 2),false)),
			'margin-left' => $gh->calcTam(array('qi' => -1)),
			'margin-right' => $gh->calcTam(array('qi' => -1)),
			'float' => 'left',
			'position' => 'relative'
	));

$this->Decorator->rule(
		'div.coluna_principal .div_intrapolante', array(
			'width' => $u->t($gh->calculaTamanhoTotal(false) + $gh->calcTam(array('qi' => -2),false)),
			'margin-left' => $gh->calcTam(array('qi' => 1)),
			'margin-right' => $gh->calcTam(array('qi' => 1)),
			'float' => 'left',
			'position' => 'relative'
	));

$this->Decorator->rule(
		'#primeiro_cabecalho', array(
			'height' => $gv->calcTam(array('qM' => 1, 'qi' => 2))
	));

$this->Decorator->rule(
		'#conteudo', array(
			'background-color' => $paleta['fundo_conteudo']->escreveCor(),
			'width' => auto
	));


.caixa
{
	background-color: <?php echo $paleta['fundo_caixotinho']->escreveCor(); ?>;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-bottom: <?php echo $gv->calcTam(array('qi' => 2));?>;
	float: left;
	padding-top: 0;
}

.caixa.transparente
{
	background-color: none;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-bottom: 0;
	float: left;
}

#conteudo .coluna .caixinha
{
	float: left;
	display: block;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-right: 0;
}

#conteudo .coluna .caixinha_2
{
	float: left;
	display: block;
	margin-left: 0;
	margin-right: 0;
}

.noticias_pagina_principal
{
	float: left;
	display: block;
	margin: 0;
	width: <?php echo $gh->calcTam(array('qM' => 3, 'qi' => 2, 'qm' => 1));?>;
}

.publicacoes_pagina_principal
{
	float: left;
	display: block;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1)); ?>;
	width: <?php echo $gh->calcTam(array('qM' => 3, 'qi' => 1.8, 'qm' => 1));?>;
}

.larg_3M_-3i_-1m
{
	width: <?php echo $gh->calcTam(array('qM' => 3, 'qi' => -3, 'qm' => -1));?>;
}

.caixote
{
	margin: 0;
	float: left;
}

.espacador_vertical
{
	margin: 0;
	float: left;
	height: <?php echo $gv->calcTam(array('qi' => 1));?>
}

.espacador_horizontal
{
	margin: 0;
	float: left;
	clear: both;
	width: <?php echo $gh->calcTam(array('qi' => 1));?>
}

<?php
// caixotes

$tam = array ('qi' => 0);

for ($qM = 1; $qM <= 12; $qM++)
{
	$tam['qM'] = $qM;
	echo _classe_largura($tam, $gh);
}

// colunas e caixas
$tam = array ('qi' => -1);

for ($qM = 1; $qM <= 12; $qM++)
{
	$tam['qM'] = $qM;
	echo _classe_largura($tam, $gh);
}

//espaçadores horizontais

$tam = array();
for($qi = 1; $qi <= 7; $qi++)
{
	$tam['qi'] = $qi;
	echo _classe_largura($tam, $gh);
}

//espaçadores verticais

$tam = array();
for($qi = 1; $qi <= 7; $qi++)
{
	$tam['qi'] = $qi;
	echo _classe_altura($tam, $gv);
}
?>



.larg_auto {width: auto;}

p {text-indent:   <?php echo $u->t($entrelinha);?>;}

p:first-child {text-indent: 0;}

.paragrafos {margin-bottom: <?php echo $u->t($entrelinha);?>;}
.coluna ul, .coluna ol {margin-bottom: <?php echo $u->t($entrelinha);?>;}
.coluna ul ul, .coluna ul ol, .coluna ol ul, .coluna ul ol {margin-bottom: 0;}


.coluna h1, .coluna h2, .coluna h3, .coluna h4, .coluna h5, .coluna p, .coluna ul, .coluna ol, .coluna form, .coluna span
{
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-right: <?php echo $gh->calcTam(array('qi' => 1));?>;
}

.coluna p span, .coluna h1 span,.coluna h2 span, .coluna h3 span, .coluna h4 span, .coluna h5 span
{
	margin: 0;
}


.coluna form
{
	margin-bottom: <?php echo $u->t($entrelinha);?>;
}

.coluna a, .menu_1_lateral a, .menu_lateral a:visited
{
	color: <?php echo $paleta['texto']->escreveCor();?>;
	border-bottom: <?php echo $u->t(2);?> solid <?php echo $paleta['texto_destaque']->escreveCor();?>;
}

.coluna a:visited
{
	color: <?php echo $paleta['texto_colorido_rebaixado']->escreveCor();?>;
}

.coluna a:hover, .coluna a:active, .menu_1_lateral a:hover, .menu_1_lateral a:active
{
	border-bottom: <?php echo $u->t(2);?> solid <?php echo $paleta['principal']->escreveCor();?>;
	background-color: <?php echo $paleta['principal']->escreveCor();?>;
}

.coluna .texto_pequeno
{
	font-size: <?php echo $u->t($tam_fonte_padrao * 11/14); ?>
}

.coluna .italico
{
	font-style: italic;
}

.flutuante
{
	float: left;
}

h1, h1 *, h2, h2 *, h3, h3 * {font-family: Georgia, serif;}

h1, h1 *, h4, h4 *, h5, h5 * {font-weight: 700;}

h1, h1 *
{
	color: <?php echo $paleta['principal']->escreveCor(); ?>;
	display: block;
	float: left;
	clear: none;
	line-height: <?php echo $u->t(30);?>;
	font-size: <?php echo $u->t(23);?>;
}

.coluna h1
{
	color: <?php echo $paleta['texto']->escreveCor(); ?>;
	display: block;
	float: none;
	clear: both;
}

h2, h2 *
{
	line-height: <?php echo $u->t(30);?>;
	font-size: <?php echo $u->t(23);?>;
	color: <?php echo $paleta['texto_destaque']->escreveCor();?>;
	font-weight: 500;
}

h3, h3 *
{
	line-height: <?php echo $u->t($entrelinha);?>;
	font-size: <?php echo $u->t(17);?>;
	font-weight: 500;
}

h4, h4 *
{
	line-height: <?php echo $u->t($entrelinha);?>;
	font-size: <?php echo $u->t($tam_fonte_padrao);?>;
	color: <?php echo $paleta['texto_destaque']->escreveCor();?>;
}

h5, h5 *
{
	line-height: <?php echo $u->t($entrelinha);?>;
	font-size: <?php echo $u->t($tam_fonte_padrao);?>;
}

ol, ol li {list-style-type: decimal; margin-left: <?php echo $u->t($entrelinha);?>;}

.colorido, .colorido *, span.colorido a
{
	color: <?php echo $paleta['texto_destaque']->escreveCor();?>;
}

.barra_h
{

	clear: both;
	width: auto;
	display: block;
	background-repeat: repeat-x;
}

.colorida_branco
{
	background-image: url('<?php echo $gerador_imagens_compostas->url(
					array(
						'w' => 1600,
						'h' => 5,
						'wi' => 1600*4,
						'hi' => 5*4,
						'nome_base' => 'barrinha_cor_fundo_cab',
						'camadas' => array(
							array('tipo' =>	'aplicar_cor', 'cor' => $paleta['fundo_cabecalho']),
							array(
*
{
	margin: 0;
	padding: 0;
	list-style: none;
	vertical-align: baseline;
	text-decoration: none;
	font-family: "Lucida Sans", "Bitstream Vera", sans;
	font-size: <?php echo $u->t($tam_fonte_padrao);?>;
	line-height: <?php echo $u->t($entrelinha);?>;
	border: none;
}

#logo
{
	margin-top: <?php echo $u->t($entrelinha/2);?>;
}

.coluna_principal
{
	width: <?php echo $gh->calculaTamanhoTotal(); ?>;
	position: relative;
	margin-left: auto;
	margin-right: auto;
}

*
{
	margin: 0;
	padding: 0;
	list-style: none;
	vertical-align: baseline;
	text-decoration: none;
	font-family: "Lucida Sans", "Bitstream Vera", sans;
	font-size: <?php echo $u->t($tam_fonte_padrao);?>;
	line-height: <?php echo $u->t($entrelinha);?>;
	border: none;
}

#logo
{
	margin-top: <?php echo $u->t($entrelinha/2);?>;
}

.coluna_principal
{
	width: <?php echo $gh->calculaTamanhoTotal(); ?>;
	position: relative;
	margin-left: auto;
	margin-right: auto;
}

div.coluna_principal .div_extrapolante
{
	width: <?php echo $u->t($gh->calculaTamanhoTotal(false) + $gh->calcTam(array('qi' => 2),false)); ?>;
	margin-left: <?php echo $gh->calcTam(array('qi' => -1));?>;
	margin-right: <?php echo $gh->calcTam(array('qi' => -1));?>;
	float: left;
	position: relative;
}

div.coluna_principal .div_intrapolante
{
	width: <?php echo $u->t($gh->calculaTamanhoTotal(false) + $gh->calcTam(array('qi' => -2),false)); ?>;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-right: <?php echo $gh->calcTam(array('qi' => 1));?>;
	float: left;
	position: relative;
}

#primeiro_cabecalho
{
	height: <?php echo $gv->calcTam(array('qM' => 1, 'qi' => 2));?>;
}

#conteudo
{
	background-color: <?php echo $paleta['fundo_conteudo']->escreveCor();?>;
	width: auto;
}

.caixa
{
	background-color: <?php echo $paleta['fundo_caixotinho']->escreveCor(); ?>;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-bottom: <?php echo $gv->calcTam(array('qi' => 2));?>;
	float: left;
	padding-top: 0;
}

.caixa.transparente
{
	background-color: none;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-bottom: 0;
	float: left;
}

#conteudo .coluna .caixinha
{
	float: left;
	display: block;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-right: 0;
}

#conteudo .coluna .caixinha_2
{
	float: left;
	display: block;
	margin-left: 0;
	margin-right: 0;
}

.noticias_pagina_principal
{
	float: left;
	display: block;
	margin: 0;
	width: <?php echo $gh->calcTam(array('qM' => 3, 'qi' => 2, 'qm' => 1));?>;
}

.publicacoes_pagina_principal
{
	float: left;
	display: block;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1)); ?>;
	width: <?php echo $gh->calcTam(array('qM' => 3, 'qi' => 1.8, 'qm' => 1));?>;
}

.larg_3M_-3i_-1m
{
	width: <?php echo $gh->calcTam(array('qM' => 3, 'qi' => -3, 'qm' => -1));?>;
}

.caixote
{
	margin: 0;
	float: left;
}

.espacador_vertical
{
	margin: 0;
	float: left;
	height: <?php echo $gv->calcTam(array('qi' => 1));?>
}

.espacador_horizontal
{
	margin: 0;
	float: left;
	clear: both;
	width: <?php echo $gh->calcTam(array('qi' => 1));?>
}

<?php
// caixotes

$tam = array ('qi' => 0);

for ($qM = 1; $qM <= 12; $qM++)
{
	$tam['qM'] = $qM;
	echo _classe_largura($tam, $gh);
}

// colunas e caixas
$tam = array ('qi' => -1);

for ($qM = 1; $qM <= 12; $qM++)
{
	$tam['qM'] = $qM;
	echo _classe_largura($tam, $gh);
}

//espaçadores horizontais

$tam = array();
for($qi = 1; $qi <= 7; $qi++)
{
	$tam['qi'] = $qi;
	echo _classe_largura($tam, $gh);
}

//espaçadores verticais

$tam = array();
for($qi = 1; $qi <= 7; $qi++)
{
	$tam['qi'] = $qi;
	echo _classe_altura($tam, $gv);
}
?>



.larg_auto {width: auto;}

p {text-indent:   <?php echo $u->t($entrelinha);?>;}

p:first-child {text-indent: 0;}

.paragrafos {margin-bottom: <?php echo $u->t($entrelinha);?>;}
.coluna ul, .coluna ol {margin-bottom: <?php echo $u->t($entrelinha);?>;}
.coluna ul ul, .coluna ul ol, .coluna ol ul, .coluna ul ol {margin-bottom: 0;}


.coluna h1, .coluna h2, .coluna h3, .coluna h4, .coluna h5, .coluna p, .coluna ul, .coluna ol, .coluna form, .coluna span
{
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-right: <?php echo $gh->calcTam(array('qi' => 1));?>;
}

.coluna p span, .coluna h1 span,.coluna h2 span, .coluna h3 span, .coluna h4 span, .coluna h5 span
{
	margin: 0;
}


.coluna form
{
	margin-bottom: <?php echo $u->t($entrelinha);?>;
}

.coluna a, .menu_1_lateral a, .menu_lateral a:visited
{
	color: <?php echo $paleta['texto']->escreveCor();?>;
	border-bottom: <?php echo $u->t(2);?> solid <?php echo $paleta['texto_destaque']->escreveCor();?>;
}

.coluna a:visited
{
	color: <?php echo $paleta['texto_colorido_rebaixado']->escreveCor();?>;
}

.coluna a:hover, .coluna a:active, .menu_1_lateral a:hover, .menu_1_lateral a:active
{
	border-bottom: <?php echo $u->t(2);?> solid <?php echo $paleta['principal']->escreveCor();?>;
	background-color: <?php echo $paleta['principal']->escreveCor();?>;
}

.coluna .texto_pequeno
{
	font-size: <?php echo $u->t($tam_fonte_padrao * 11/14); ?>
}

.coluna .italico
{
	font-style: italic;
}

.flutuante
{
	float: left;
}

h1, h1 *, h2, h2 *, h3, h3 * {font-family: Georgia, serif;}

h1, h1 *, h4, h4 *, h5, h5 * {font-weight: 700;}

h1, h1 *
{
	color: <?php echo $paleta['principal']->escreveCor(); ?>;
	display: block;
	float: left;
	clear: none;
	line-height: <?php echo $u->t(30);?>;
	font-size: <?php echo $u->t(23);?>;
}

.coluna h1
{
	color: <?php echo $paleta['texto']->escreveCor(); ?>;
	display: block;
	float: none;
	clear: both;
}

h2, h2 *
{
	line-height: <?php echo $u->t(30);?>;
	font-size: <?php echo $u->t(23);?>;
	color: <?php echo $paleta['texto_destaque']->escreveCor();?>;
	font-weight: 500;
}

h3, h3 *
{
	line-height: <?php echo $u->t($entrelinha);?>;
	font-size: <?php echo $u->t(17);?>;
	font-weight: 500;
}

h4, h4 *
{
	line-height: <?php echo $u->t($entrelinha);?>;
	font-size: <?php echo $u->t($tam_fonte_padrao);?>;
	color: <?php echo $paleta['texto_destaque']->escreveCor();?>;
}

h5, h5 *
{
	line-height: <?php echo $u->t($entrelinha);?>;
	font-size: <?php echo $u->t($tam_fonte_padrao);?>;
}

ol, ol li {list-style-type: decimal; margin-left: <?php echo $u->t($entrelinha);?>;}

.colorido, .colorido *, span.colorido a
{
	color: <?php echo $paleta['texto_destaque']->escreveCor();?>;
}

.barra_h
{

	clear: both;
	width: auto;
	display: block;
	background-repeat: repeat-x;
}

.colorida_branco
{
	background-image: url('<?php echo $gerador_imagens_compostas->url(
					array(
						'w' => 1600,
						'h' => 5,
						'wi' => 1600*4,
						'hi' => 5*4,
						'nome_base' => 'barrinha_cor_fundo_cab',
						'camadas' => array(
							array('tipo' =>	'aplicar_cor', 'cor' => $paleta['fundo_cabecalho']),
							array(
*
{
	margin: 0;
	padding: 0;
	list-style: none;
	vertical-align: baseline;
	text-decoration: none;
	font-family: "Lucida Sans", "Bitstream Vera", sans;
	font-size: <?php echo $u->t($tam_fonte_padrao);?>;
	line-height: <?php echo $u->t($entrelinha);?>;
	border: none;
}

#logo
{
	margin-top: <?php echo $u->t($entrelinha/2);?>;
}

.coluna_principal
{
	width: <?php echo $gh->calculaTamanhoTotal(); ?>;
	position: relative;
	margin-left: auto;
	margin-right: auto;
}

div.coluna_principal .div_extrapolante
{
	width: <?php echo $u->t($gh->calculaTamanhoTotal(false) + $gh->calcTam(array('qi' => 2),false)); ?>;
	margin-left: <?php echo $gh->calcTam(array('qi' => -1));?>;
	margin-right: <?php echo $gh->calcTam(array('qi' => -1));?>;
	float: left;
	position: relative;
}

div.coluna_principal .div_intrapolante
{
	width: <?php echo $u->t($gh->calculaTamanhoTotal(false) + $gh->calcTam(array('qi' => -2),false)); ?>;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-right: <?php echo $gh->calcTam(array('qi' => 1));?>;
	float: left;
	position: relative;
}

#primeiro_cabecalho
{
	height: <?php echo $gv->calcTam(array('qM' => 1, 'qi' => 2));?>;
}

#conteudo
{
	background-color: <?php echo $paleta['fundo_conteudo']->escreveCor();?>;
	width: auto;
}

.caixa
{
	background-color: <?php echo $paleta['fundo_caixotinho']->escreveCor(); ?>;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-bottom: <?php echo $gv->calcTam(array('qi' => 2));?>;
	float: left;
	padding-top: 0;
}

.caixa.transparente
{
	background-color: none;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-bottom: 0;
	float: left;
}

#conteudo .coluna .caixinha
{
	float: left;
	display: block;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-right: 0;
}

#conteudo .coluna .caixinha_2
{
	float: left;
	display: block;
	margin-left: 0;
	margin-right: 0;
}

.noticias_pagina_principal
{
	float: left;
	display: block;
	margin: 0;
	width: <?php echo $gh->calcTam(array('qM' => 3, 'qi' => 2, 'qm' => 1));?>;
}

.publicacoes_pagina_principal
{
	float: left;
	display: block;
	margin-left: <?php echo $gh->calcTam(array('qi' => 1)); ?>;
	width: <?php echo $gh->calcTam(array('qM' => 3, 'qi' => 1.8, 'qm' => 1));?>;
}

.larg_3M_-3i_-1m
{
	width: <?php echo $gh->calcTam(array('qM' => 3, 'qi' => -3, 'qm' => -1));?>;
}

.caixote
{
	margin: 0;
	float: left;
}

.espacador_vertical
{
	margin: 0;
	float: left;
	height: <?php echo $gv->calcTam(array('qi' => 1));?>
}

.espacador_horizontal
{
	margin: 0;
	float: left;
	clear: both;
	width: <?php echo $gh->calcTam(array('qi' => 1));?>
}

<?php
// caixotes

$tam = array ('qi' => 0);

for ($qM = 1; $qM <= 12; $qM++)
{
	$tam['qM'] = $qM;
	echo _classe_largura($tam, $gh);
}

// colunas e caixas
$tam = array ('qi' => -1);

for ($qM = 1; $qM <= 12; $qM++)
{
	$tam['qM'] = $qM;
	echo _classe_largura($tam, $gh);
}

//espaçadores horizontais

$tam = array();
for($qi = 1; $qi <= 7; $qi++)
{
	$tam['qi'] = $qi;
	echo _classe_largura($tam, $gh);
}

//espaçadores verticais

$tam = array();
for($qi = 1; $qi <= 7; $qi++)
{
	$tam['qi'] = $qi;
	echo _classe_altura($tam, $gv);
}
?>



.larg_auto {width: auto;}

p {text-indent:   <?php echo $u->t($entrelinha);?>;}

p:first-child {text-indent: 0;}

.paragrafos {margin-bottom: <?php echo $u->t($entrelinha);?>;}
.coluna ul, .coluna ol {margin-bottom: <?php echo $u->t($entrelinha);?>;}
.coluna ul ul, .coluna ul ol, .coluna ol ul, .coluna ul ol {margin-bottom: 0;}


.coluna h1, .coluna h2, .coluna h3, .coluna h4, .coluna h5, .coluna p, .coluna ul, .coluna ol, .coluna form, .coluna span
{
	margin-left: <?php echo $gh->calcTam(array('qi' => 1));?>;
	margin-right: <?php echo $gh->calcTam(array('qi' => 1));?>;
}

.coluna p span, .coluna h1 span,.coluna h2 span, .coluna h3 span, .coluna h4 span, .coluna h5 span
{
	margin: 0;
}


.coluna form
{
	margin-bottom: <?php echo $u->t($entrelinha);?>;
}

.coluna a, .menu_1_lateral a, .menu_lateral a:visited
{
	color: <?php echo $paleta['texto']->escreveCor();?>;
	border-bottom: <?php echo $u->t(2);?> solid <?php echo $paleta['texto_destaque']->escreveCor();?>;
}

.coluna a:visited
{
	color: <?php echo $paleta['texto_colorido_rebaixado']->escreveCor();?>;
}

.coluna a:hover, .coluna a:active, .menu_1_lateral a:hover, .menu_1_lateral a:active
{
	border-bottom: <?php echo $u->t(2);?> solid <?php echo $paleta['principal']->escreveCor();?>;
	background-color: <?php echo $paleta['principal']->escreveCor();?>;
}

.coluna .texto_pequeno
{
	font-size: <?php echo $u->t($tam_fonte_padrao * 11/14); ?>
}

.coluna .italico
{
	font-style: italic;
}

.flutuante
{
	float: left;
}

h1, h1 *, h2, h2 *, h3, h3 * {font-family: Georgia, serif;}

h1, h1 *, h4, h4 *, h5, h5 * {font-weight: 700;}

h1, h1 *
{
	color: <?php echo $paleta['principal']->escreveCor(); ?>;
	display: block;
	float: left;
	clear: none;
	line-height: <?php echo $u->t(30);?>;
	font-size: <?php echo $u->t(23);?>;
}

.coluna h1
{
	color: <?php echo $paleta['texto']->escreveCor(); ?>;
	display: block;
	float: none;
	clear: both;
}

h2, h2 *
{
	line-height: <?php echo $u->t(30);?>;
	font-size: <?php echo $u->t(23);?>;
	color: <?php echo $paleta['texto_destaque']->escreveCor();?>;
	font-weight: 500;
}

h3, h3 *
{
	line-height: <?php echo $u->t($entrelinha);?>;
	font-size: <?php echo $u->t(17);?>;
	font-weight: 500;
}

h4, h4 *
{
	line-height: <?php echo $u->t($entrelinha);?>;
	font-size: <?php echo $u->t($tam_fonte_padrao);?>;
	color: <?php echo $paleta['texto_destaque']->escreveCor();?>;
}

h5, h5 *
{
	line-height: <?php echo $u->t($entrelinha);?>;
	font-size: <?php echo $u->t($tam_fonte_padrao);?>;
}

ol, ol li {list-style-type: decimal; margin-left: <?php echo $u->t($entrelinha);?>;}

.colorido, .colorido *, span.colorido a
{
	color: <?php echo $paleta['texto_destaque']->escreveCor();?>;
}

.barra_h
{

	clear: both;
	width: auto;
	display: block;
	background-repeat: repeat-x;
}

.colorida_branco
{
	background-image: url('<?php echo $gerador_imagens_compostas->url(
					array(
						'w' => 1600,
						'h' => 5,
						'wi' => 1600*4,
						'hi' => 5*4,
						'nome_base' => 'barrinha_cor_fundo_cab',
						'camadas' => array(
							array('tipo' =>	'aplicar_cor', 'cor' => $paleta['fundo_cabecalho']),
							array(
								'tipo' =>	'imagem_colorizada',
								'caminho' => '/img/matrizes/barrinha_vermelha_fundo_cabecalho_fundo_aplicacao.png',
								'cor' => $paleta['principal']
							)
						)
					)
				);?>');
	height: <?php echo $u->t(4);?>;
	margin-bottom: <?php echo $gv->calcTam(array('qi' => 1));?>;
}

.colorida_branco_cinza
{
	background-image: url('<?php
		echo $gerador_imagens_compostas->url(
		array(
			'w' => 1600,
			'h' => 4,
			'wi' => 1600*4,
			'hi' => 4*4,
			'nome_base' => 'barrinha_topo',
			'camadas' => array(
				array('tipo' => 'aplicar_cor', 'cor' => $paleta['fundo_cabecalho']),
				array(
					'tipo' =>	'imagem_colorizada',
					'caminho' => '/img/matrizes/barrinha_barrao_c-principal_f1-fundo_cabecalho_f2-fundo_conteudo.png',
					'cor' => $paleta['fundo_conteudo']
				),
				array(
					'tipo' => 'imagem_colorizada',
					'caminho' => '/img/matrizes/barrinha_pont_c-principal_f1-fundo_cabecalho_f2-fundo_conteudo.png',
					'cor' => $paleta['principal']
				)
			)
		)
	);
	?>');
	height: <?php echo $u->t(4);?>;
	margin-top: <?php echo $gv->calcTam(array('qi' => 0.5));?>;
}

.colorida_cinza_branco {
	background-image: url('<?php
		echo $gerador_imagens_compostas->url(
		array(
			'w' => 1600,
			'h' => 6,
			'wi' => 1600*4,
			'hi' => 6*4,
			'nome_base' => 'barrinha_baixo',
			'camadas' => array(
				array('tipo' => 'aplicar_cor', 'cor' => $paleta['fundo_cabecalho']),
				array(
					'tipo' =>	'imagem_colorizada',
					'caminho' => '/img/matrizes/barrinha_barrao_c-principal_f1-fundo_conteudo_f2-fundo_cabecalho.png',
					'cor' => $paleta['fundo_conteudo']
				),
				array(
					'tipo' => 'imagem_colorizada',
					'caminho' => '/img/matrizes/barrinha_pont_c-principal_f1-fundo_conteudo_f2-fundo_cabecalho.png',
					'cor' => $paleta['principal']
				)
			)
		)
	);
	?>');
	height: <?php echo $u->t(5);?>;
}

.cinza_branco
{
	<?php
	$altura = 5;
	$cima = floor($entrelinha - 5)/2;
	$baixo = $entrelinha - 5 - $cima;
	?>
	height: <?php echo $u->t($altura);?>;
	background-image: url('<?php
		echo $gerador_imagens_compostas->url(
		array(
			'w' => 1600,
			'h' => 5,
			'wi' => 1600*4,
			'hi' => 5*4,
			'nome_base' => 'barrinha_c-fundo_conteudo_f-fundo_caixotinho',
			'camadas' => array(
				array('tipo' =>	'aplicar_cor', 'cor' => $paleta['fundo_caixotinho']),
				array(
					'tipo' => 'imagem_colorizada',
					'caminho' => '/img/matrizes/barrinha_c-fundo_conteudo_f-fundo_caixotinho.png',
					'cor' => $paleta['fundo_conteudo']
				)
			)
		)
	);
	?>');
	margin-bottom: <?php echo $u->t($baixo);?>;
	margin-top: <?php echo $u->t($cima);?>;
}

.tracejada_cinza_branco
{
	background-image: url('<?php
		echo $gerador_imagens_compostas->url(
		array(
			'w' => 1028,
			'h' => 3,
			'wi' => 1028*4,
			'hi' => 3*4,
			'nome_base' => 'barrinha_tracejada',
			'camadas' => array(
				array('tipo' => 'aplicar_cor', 'cor' => $paleta['fundo_cabecalho']),
				array(
					'tipo' =>	'imagem_colorizada',
					'caminho' => '/img/matrizes/barrinha_tracejada_c-fundo_conteudo_f-fundo_cabecalho.png',
					'cor' => $paleta['fundo_conteudo']
				)
			)
		)
	);
	?>');
	height:<?php echo $u->t(2);?>;
	margin-top: <?php echo $gv->calcTam(array('qi' => 0.5));?>;
	margin-bottom: <?php echo $gv->calcTam(array('qi' => 0.5));?>;
}


.limpador
{
	clear: both;
}

.menu_0 *
{
	font-family: Georgia, serif;
	font-size:  <?php echo $u->t($tam_fonte_padrao * 18/14);?>;
	line-height: <?php echo $u->t($entrelinha * 30/20);?>;
}

.menu_0
{
	margin-top: <?php echo $gv->calcTam(array('qM' => 1/2));?>;
}

.menu_0 a
{
	color: <?php echo $paleta['texto']->escreveCor(); ?>;
}

.menu_0 a:hover, .menu_0 a:active, .menu_0 a.selecionado
{
	color: <?php echo $paleta['principal']->escreveCor(); ?>;
}

.menu_1_lateral
{
	float: right;
	margin-top: <?php echo $u->t($entrelinha/3);?>;
}

.spsassd_menu *, .menu_1 *
{
	font-family: Georgia, serif;
	font-size: <?php echo $u->t(15);?>;
}

.spsassd_menu a, .menu_1 a {color: <?php echo $paleta['texto']->escreveCor();?>;}
.spsassd_menu a:hover, .menu_1 a:hover, .menu_1 a.selecionado {color: <?php echo $paleta['texto_destaque']->escreveCor();?>;}
.spsassd_menu a:active, .menu_1 a:active {color: <?php echo $paleta['texto_destaque']->escreveCor();?>;}


.input.text label, .input.textarea label, .input.password label,
fieldset legend{display: block; font-weight: bold;}

.input.text, .input.password {margin-bottom: <?php echo $gv->calcTam(array('qi' => 1));?>}
.input.text input, .input.password input, label input
{
	background-color: <?php echo $paleta['input_texto']->escreveCor();?>;
	width: <?php echo $gh->calcTam(array('qM' => 3));?>;
	height: <?php echo $u->t($entrelinha);?>;
	line-height: <?php echo $u->t($entrelinha);?>;
}

.input.textarea{margin-bottom: <?php echo $gv->calcTam(array('qi' => 1));?>}

.input.textarea textarea
{
	background-color: <?php echo $paleta['input_texto']->escreveCor();?>;
	width: <?php echo $gh->calcTam(array('qM' => 3));?>;
	height: <?php echo $u->t($entrelinha*5);?>;
}


.input.radio{margin-bottom: <?php echo $gv->calcTam(array('qi' => 1));?>;}
.input.radio label
{
	height: <?php echo $u->t($entrelinha);?>;
	line-height: <?php echo $u->t($entrelinha);?>;
}

.input.radio input
{
	margin-right: <?php echo $gh->calcTam(array('qi' => 0.5));?>;
}

.submit input
{
	width: <?php echo $gh->calcTam(array('qM' => 3));?>;
	height: <?php echo $u->t($entrelinha*1.5);?>;
}
.form-error
{
	border: 1px solid <?php echo $paleta['mensagem_erro']->escreveCor();?>;
}

.error-message
{
	color: <?php echo $paleta['mensagem_erro']->escreveCor();?>;
}

div#excecao p a
{
	border: 0;
	background-color: #FFFFFF;
}

div#excecao p a:hover, div#excecao p a:active,
{
	background-color: #FFFFFF;
}

#rodape
{
	height: <?php echo $gv->calcTam(array('qM' => 5));?>;
	background-color: <?php echo $paleta['fundo_rodape']->escreveCor();?>;
}

#rodape p, #rodape a, #rodape b, #rodape *
{
	line-height: <?php echo $gv->calcTam(array('qi' => 1.4));?>;
	font-size: <?php echo $gv->calcTam(array('qi' => 0.9));?>;
}

#atrator_rodape
{
	height: <?php echo $gv->calcTam(array('qM' => 5, 'qi' => -2));?>;
	width: <?php echo $gh->calcTam(array('qM' => 7));?>;
	float: left;

	background-image: url('<?php echo $gerador_imagens_compostas->url(
					array(
						'w' => 576,
						'h' => 548,
						'nome_base' => 'atrator' . $_SESSION['kulepona_n_atrator'],
						'camadas' => array(
							array('tipo' =>	'aplicar_cor', 'cor' => $paleta['fundo_cabecalho']),
							array(
								'tipo' => 'imagem_colorizada',
								'caminho' => '/img/matrizes/atrator'.$_SESSION['kulepona_n_atrator'].'.png',
								'cor' => $paleta['atrator']
							)
						)
					)
				);?>');
	background-repeat: no-repeat;
	background-position: <?php echo $gh->calcTam(array('qi' => -4)); echo ' ' .  $gv->calcTam(array('qM' => -2));?>;
}

#atrator_aleatorio
{
	height: <?php echo $gv->calcTam(array('qM' => 4, 'qi' => -4));?>;
	width: auto;

	background-image: url('<?php
					$atrator = rand(2,6);
					echo $gerador_imagens_compostas->url(
					array(
						'w' => 576,
						'h' => 548,
						'nome_base' => 'atrator' . $atrator,
						'camadas' => array(
							array('tipo' =>	'aplicar_cor', 'cor' => $paleta['fundo_cabecalho']),
							array(
								'tipo' => 'imagem_colorizada',
								'caminho' => '/img/matrizes/atrator'.$atrator.'.png',
								'cor' => $paleta['atrator']
							)
						)
					)
				);?>');
	background-repeat: no-repeat;
	background-position: <?php echo $gh->calcTam(array('qi' => -1));?> <?php echo $gv->calcTam(array('qi' => -4));?>;
}

.topo_caixa
{
	height: <?php echo $u->t($imagem_topo_caixas->altura_max); //seria necessario reconverter aqui no caso de se usar um layout de impressao?>;
	margin-bottom: <?php echo $gv->calcTam(array('qm' => 1, 'qi' => 0)); ?>;
}



?>
