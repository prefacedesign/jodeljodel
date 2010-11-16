<?php //aqui vão as rules de CSS 
	
	$typeDecorator->rule(
		'.box_container', 
		array(
			'float' => 'left'
		)
	);
	
	$typeDecorator->rule(
		'.box',
		array(
			'float' => 'left',
			'margin-left' => $hg->size(array('g' => 1))
		)
	);
	
	$typeDecorator->rule(
		'.float_break', 
		array(
			'clear' => 'both'
		)
	);
	
	$typeDecorator->rule(
		'*',
		array(
			'border' => 'none',
			'margin' => '0',
			'padding' => '0',
			'text-decoration' => 'none',
			'font-family' => 'Georgia, Cambria, FreeSerif, serif'
		)
	);
	
	$typeDecorator->rule(
		'body',
		array(
			'background-color' => $palette['bg']->write(),
			'font-size'        => $u->t($line_height * 13/18),
			'line-height'      => $u->t($line_height),
			'color'            => $palette['text']->write()
		)
	);
?>
