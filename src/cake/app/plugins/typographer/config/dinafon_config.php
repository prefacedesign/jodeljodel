<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

App::import('Vendor','Typographer.tools');
App::import('Vendor','Typographer.dinafon_tools');
App::import('Vendor','browserdetection');

$browserInfo = getBrowser();

if (!isset($_SESSION))
{
	session_name('CAKEPHP');
	session_start();
}

if (!isset($_SESSION['kulepona_cor']))
{
	$_SESSION['kulepona_cor']       = rand(0,2);
	$_SESSION['kulepona_n_logo']    = rand(1,6);
	$_SESSION['kulepona_n_atrator'] = rand(2,6);
}


$paleta = array();
$paleta['texto'] = new Color (0,0,0);
$paleta['fundo_cabecalho']  = new Color(255,255,255);
$paleta['fundo_rodape']     = new Color(255,255,255);
$paleta['fundo_caixotinho'] = new Color(255,255,255);


$paletas = array();

//paleta vermelha

$ind = 1;
$p[$ind] = array();
$p[$ind]['principal'] = new Color(242,0,0);
$p[$ind]['auxiliar'] = new Color(255,255,0); //usada para puxar o cinza

//paleta verde

$ind = 2;
$p[$ind] = array();
$p[$ind]['principal'] = new Color(9,195,20);
$p[$ind]['auxiliar'] = new Color(220,255,180); //usada para puxar o cinza

//paleta azul

$ind = 0;
$p[$ind] = array();
$p[$ind]['principal'] = new Color(30,60,208);
$p[$ind]['auxiliar'] = new Color(180,255,70); //usada para puxar o cinza


$paleta['principal'] = $p[$_SESSION['kulepona_cor']]['principal'];
$paleta['auxiliar'] = $p[$_SESSION['kulepona_cor']]['auxiliar'];

//calcula as outras "sub-cores"

$paleta['texto_destaque'] = new Color(45,67,70); //só para criar a cor
$paleta['texto_destaque']->blendWith($paleta['texto'], 1);
$paleta['texto_destaque']->blendWith($paleta['principal'], 0.92);


$paleta['texto_colorido_rebaixado'] = new Color(77,77,77);
$paleta['texto_colorido_rebaixado']->blendWith($paleta['principal'], 1); //atribuição
$paleta['texto_colorido_rebaixado']->blendWith(new Color(255,255,255),0.85);
$paleta['texto_colorido_rebaixado']->blendWith($paleta['texto'],0.70);


$paleta['fundo_conteudo'] = new Color(77,77,77);
$paleta['fundo_conteudo']->blendWith($paleta['auxiliar'], 1); //atribuição
$paleta['fundo_conteudo']->blendWith(new Color(235,235,235),0.9);

$paleta['input_texto'] = new Color(255,255,255); //atribuição
$paleta['input_texto']->blendWith($paleta['principal'], 0.17);
$paleta['input_texto']->blendWith($paleta['auxiliar'], 0.03);

$paleta['mensagem_erro'] = $paleta['texto_destaque'];

$paleta['atrator'] = new Color(0,0,0);
$paleta['atrator']->blendWith($paleta['principal'], 0.65);

$paleta['teste'][0] = new Color(222,0,100);
$paleta['teste'][1] = new Color(0,222,100);
$paleta['teste'][2] = new Color(222,100,0);
$paleta['teste'][3] = new Color(0,100,222);
$paleta['teste'][4] = new Color(100,0,222);
$paleta['teste'][5] = new Color(100,222,0);

$unit = new Unit(
	array(
		'unit_name' => 'px',
		'multiplier' => 1,
		'round_it' => true
	)
);

$horizontal_grid = new Grid(array(
	'M_size' => 82,
	'm_size' => 6,
	'g_size' => 12,
	'M_quantity' => 12,
	'alignment' => 'left',
	'left_gutter'  => 0,
	'right_gutter' => 0,
	'unit' => &$unit
));

$vertical_grid = $horizontal_grid;

$lineHeight = floor($horizontal_grid->size(array('g' => 1), false) * (4/3) * (4/3));
$standard_font_size = 14;


$image_generator = new CompoundImage;

$used_automatic_classes = array(
	'width' => array()
);

for ($i = 1; $i <= 12; $i++)
{
	$used_automatic_classes['width'][] = array('M' => $i, 'g' => -1);
	$used_automatic_classes['width'][] = array('M' => $i, 'g' =>  0);
}

for ($i = 1; $i <= 7; $i++)
{
	$used_automatic_classes['width'][] = array('g' => $i);
}

$used_automatic_classes['width'][] = array('M' => 3, 'g' =>  -3, 'm' => -1);

for ($i = 1; $i <= 7; $i++)
{
	$used_automatic_classes['height'][] = array('g' => $i);
}

$imagem_topo_caixas = 
	new ImagemTopoCaixas(array(
		'vg' => $vertical_grid,
		'hg' => $horizontal_grid,
		'u'  => $unit
	)
);

Configure::write('Typographer.Dinafon.tools',
					array(
						'vg' => $vertical_grid,
						'hg' => $horizontal_grid,
						'u'  => $unit,
						'lineHeight' => $lineHeight,
						'ig' => $image_generator,
						'imagem_topo_caixas' => $imagem_topo_caixas,
						'palette' => $paleta,
						'browserInfo' => $browserInfo,
						'standardFontSize' => $standard_font_size
					)
				);
Configure::write('Typographer.Dinafon.used_automatic_classes', $used_automatic_classes);
?>
