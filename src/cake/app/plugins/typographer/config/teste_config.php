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

// @todo write documentation for this config file
// @todo allow users to create their own layout scheme as a separate plugin

App::import('Vendors','Estilista.tools');

$palette = array(
	'text' => new Color(  0,  0,  0),
	'bg'   => new Color(255,255,255)
);


// @todo create tests for it to really allow same layout for browser
//    and print. In the sense that images will scale accordingly, and increase
//    it resolution under print.
$unit = new Unit(
	array(
		'unit_name' => 'px',
		'multiplier' => 1,
		'round_it' => true
	)
);

// @todo Create a basic layout instrument to create the basic for the layout.
$horizontal_grid = new Grid(
	array(
		'M_size' => 80,
		'm_size' => round(80/8,0),
		'g_size' => round(80/8,0),
 		'M_quantity' => 12,
		'alignment' => 'left',
		'left_gutter'  => 0,
		'right_gutter' => 0,
		'unit' => &$unit
	)
);

$vertical_grid = &$horizontal_grid;

// @todo make it allow strings instead of this odd size specification array
$line_height = $horizontal_grid->size(array('g' => 2), false);

$image_generator = new CompoundImage;

// @todo improve the concept of automated class generation, allow for replacement
//   of class names and reduced size.

$used_automatic_classes = array(
	'width' => array()
);

for ($i = 1; $i <= 12; $i++)
{	
	$used_automatic_classes['width'][] = array('M' => $i, 'g' => -1);
	$used_automatic_classes['width'][] = array('M' => $i, 'g' =>  0);
}

for ($i = 1; $i <= 4; $i++)
{
	$used_automatic_classes['height'][] = array('M' => 0, 'g' => $i);
}

// @todo Improve the way that we choose the layout instruments we are going
//   to use, and the way it handles shortnames.
// Passamos para o configure os objetos

Configure::write('Typographer.Teste.tools', 
					array(
						'vg' => $vertical_grid, 
						'hg' => $horizontal_grid, 
						'u'  => $unit,
						'line_height' => $line_height,
						'ig' => $image_generator,
						'palette' => $palette
					)
				);
Configure::write('Typographer.Teste.used_automatic_classes', $used_automatic_classes);
?>