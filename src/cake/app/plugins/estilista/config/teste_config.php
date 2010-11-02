<?php
// @todo write documentation for this config file
// @todo allow users to create their own layout scheme as a separate plugin

App::import('Vendors','Estilista.instrumentos');

$paleta = array(
	'texto'        => new Cor(  0,  0,  0),
	'fundo'        => new Cor(255,255,255)
}


// @todo create tests for it to really allow same layout for browser
//    and print. In the sense that images will scale accordingly, and increase
//    it resolution under print.
$unidade = new Unidade(
	array(
		'nome_unidade' => 'px',
		'multiplicador' => 1,
		'arredonda' => true
	)
);

// @todo Create a basic layout instrument to create the basic for the layout.
$grade_horizontal = new Grade(
	array(
		'M' => 80,
		'm' => round(80/8,0),
		'i' => round(80/8,0),
 		'q' => 12,
		'alinhamento' => 'esquerda',
		'm_esquerda'  => 0,
		'm_direita' => 0,
		'unidade' => &$unidade
	)
);

$grade_vertical = &$grade_horizontal;

// @todo make it allow strings instead of this odd size specification array
$entrelinha = $grade_horizontal->calcTam(array('qi' => 2), false);

$gerador_de_imagens = new ImagemComposta;

// @todo improve the concept of automated class generation, allow for replacement
//   of class names and reduced size.

$classes_automaticas_usadas = array(
	'largura' => array()
);

for ($i = 1; $i <= 12; $i++)
{	
	$classes_automaticas_usadas['largura'][] = array('qM' => $i, 'qi' => -1);
	$classes_automaticas_usadas['largura'][] = array('qM' => $i, 'qi' =>  0);
}

for ($i = 1; $i <= 4; $i++)
{
	$classes_automaticas_usadas['altura'][] = array('qM' => 0, 'qi' => $i);
}


// @todo Improve the way that we choose the layout instruments we are going
//   to use, and the way it handles shortnames.
// Passamos para o configure os objetos

Configure::write('Estilista.Conexoes.instrumentos', 
					array(
						'gv' => $grade_vertical, 
						'gh' => $grade_horizontal, 
						'u'  => $unidade,
						'entrelinha' => $entrelinha,
						'ig' => $gerador_de_imagens,
						'paleta' => $paleta
					)
				);
Configure::write('Estilista.Conexoes.classes_automaticas_usadas', $classes_automaticas_usadas);
?>