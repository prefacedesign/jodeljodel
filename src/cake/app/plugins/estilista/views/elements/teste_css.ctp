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
?>
