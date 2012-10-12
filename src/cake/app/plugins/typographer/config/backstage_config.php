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
App::import('Vendor','browserdetection');

$browserInfo = getBrowser();

$palette = array();
$palette['text']               = new Color(  0,  0,  0);
$palette['bg']                 = new Color(255,255,255);
$palette['read_only_bg']       = new Color(255,240,255);
$palette['visited_links']      = new Color(122,130,120);
$palette['separation_lines']   = new Color(  0,  0,  0);
$palette['menu_bg']            = new Color(232,229,220);
$palette['shadows']            = new Color(122,130,120);
$palette['bg_diagonal_lines']  = new Color(174,179,192);
$palette['menu_border']        = new Color(155,153,146);
$palette['selected_tab_bg']    = new Color(255,255,255);
$palette['unselected_tab_bg']  = new Color(179,182,191);
$palette['unselected_tab_text']  = new Color(239,237,237);
$palette['meta_menu_bg']       = new Color(255,246,255);
$palette['control_box_bg']     = new Color( 82, 80, 74);
$palette['control_box_fg']     = new Color(255,255,255);
$palette['internal_selection'] = new Color(103, 99,177);
$palette['selection']          = new Color(214,229,255);
$palette['button_bg']          = new Color(213,255,159);
$palette['button_bg_disabled'] = clone $palette['button_bg'];
$palette['button_bg_disabled']->blendWith($palette['bg'], 0.75);
$palette['button_fg_disabled'] = clone $palette['text'];
$palette['button_fg_disabled']->blendWith($palette['bg'], 0.75);
$palette['button_bg_hover']    = new Color(234,255,207);
$palette['button_bg_active']   = new Color(  0,  0,  0);
$palette['subitem_title']	   = new Color(200,200,200);
$palette['subform']            = new Color(216,229,255);
$palette['subform2']           = new Color(196,209,235);
$palette['wrong_tag_bg']       = new Color(255,223,199);
$palette['tag_bg']             = new Color(229,235,213);
$palette['input_fg']           = new Color(  0,  0,  0);	
$palette['input_bg']           = new Color(255,255,255);
$palette['input_borders']      = new Color(  0,  0,  0);
$palette['input_error_bg']     = new Color(255,235,220);
$palette['input_error_fg']     = new Color(  0,  0,  0);
$palette['error_message']      = new Color(237, 28, 36);
$palette['success_message']    = new Color(  0,132, 54);
$palette['error_popin']        = new Color(255,213,185);
$palette['normal_popin']       = new Color(216,229,255);
$palette['progress_popin']     = new Color(234,229,219);
$palette['popin_bg']           = new Color(255,244,127);
$palette['popin_fg']           = new Color(  0,  0,  0);
$palette['popin_shadow']       = new Color(  0,  0,  0);
$palette['textile']            = new Color( 95, 91, 82);
$palette['help_icon']          = new Color(103, 99,177);
$palette['toolbar_content_stream_item'] = new Color(255,255,245);
$palette['info_box_bg']        = new Color(213, 229, 255);
$palette['info_box_fg']        = new Color(0, 0, 0);

$unit = new Unit(
	array(
		'unit_name' => 'px',
		'multiplier' => 1,
		'round_it' => true
	)
);


$horizontal_grid = new Grid(
	array(
		'M_size' => 80,
		'm_size' => 5,
		'g_size' => 18,
 		'M_quantity' => 12,
		'alignment' => 'center',
		'left_gutter'  => 18,
		'right_gutter' => 18,
		'unit' => &$unit
	)
);

$vertical_grid = &$horizontal_grid;

$line_height = $horizontal_grid->size(array('g' => 1), false);

$letterSpacing = '0.135ex';

$image_generator = new CompoundImage;

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

Configure::write('Typographer.Backstage.tools', 
					array(
						'vg' => $vertical_grid, 
						'hg' => $horizontal_grid, 
						'u'  => $unit,
						'line_height' => $line_height,
						'ig' => $image_generator,
						'palette' => $palette,
						'browserInfo' => $browserInfo,
						'letterSpacing' => $letterSpacing
					)
				);
Configure::write('Typographer.Backstage.used_automatic_classes', $used_automatic_classes);
?>
