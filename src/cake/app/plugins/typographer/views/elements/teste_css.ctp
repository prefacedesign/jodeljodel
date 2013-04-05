<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

	
	$decorator->rule(
		'.box_container', 
		array(
			'float' => 'left'
		)
	);
	
	$decorator->rule(
		'.box',
		array(
			'float' => 'left',
			'margin-left' => $hg->size(array('g' => 1))
		)
	);
	
	$decorator->rule(
		'.float_break', 
		array(
			'clear' => 'both'
		)
	);
	
	$decorator->rule(
		'*',
		array(
			'border' => 'none',
			'margin' => '0',
			'padding' => '0',
			'text-decoration' => 'none',
			'font-family' => 'Georgia, Cambria, FreeSerif, serif'
		)
	);
	
	$decorator->rule(
		'body',
		array(
			'background-color' => $palette['bg']->write(),
			'font-size'        => $u->t(floor($line_height * 13/20)),
			'line-height'      => $u->t($line_height),
			'color'            => $palette['text']->write()
		)
	);
?>
