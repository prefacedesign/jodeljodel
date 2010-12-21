<?php

App::import('Vendors','Typographer.tools');

$palette = array(
	'text' 	             => new Color(  0,  0,  0),
	'bg'				 => new Color(255,255,255),
	'read_only_bg'		 => new Color(255,240,255),
	'visited_links'		 => new Color(122,130,120),
	'separation_lines'   => new Color(  0,  0,  0),
	'menu_bg'            => new Color(232,229,220),
	'shadows'			 => new Color(122,130,120),
	'bg_diagonal_lines'  => new Color(174,179,192),
	'menu_border'        => new Color(155,153,146),
	'selected_tab_bg'    => new Color(255,255,255),
	'unselected_tab_bg'  => new Color(179,182,191),
	'meta_menu_bg'		 => new Color(255,246,255),
	'control_box_bg' 	 => new Color( 82, 80, 74),
	'control_box_fg'	 => new Color(255,255,255),
	'internal_selection' => new Color(103, 99,177),
	'selection'			 => new Color(214,229,255),
	'button_bg'			 => new Color(213,255,159),
	'active_button_bg'   => new Color(  0,  0,  0),
	'wrong_tag_bg'		 => new Color(255,223,199),
	'tag_bg'			 => new Color(229,235,213),
	'input_fg'			 => new Color(  0,  0,  0),	
	'input_bg'			 => new Color(255,255,255),
	'input_borders'		 => new Color(  0,  0,  0),
	'input_error_bg'	 => new Color(255,214,186),
	'input_error_fg'	 => new Color(  0,  0,  0),
	'error_message'		 => new Color(237, 28, 36),
	'success_message'	 => new Color(  0,132, 54),
	'popin_bg'			 => new Color(255,244,127),
	'popin_fg'			 => new Color(  0,  0,  0),
	'textile'			 => new Color( 95, 91, 82),
	'help_icon'			 => new Color(103, 99,177),
	'toolbar_content_stream_item' => new Color(255,255,245),
	'info_box_bg'		=> new Color(213, 229, 255),
	'info_box_fg'		=> new Color(0, 0, 0)
);

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
		'm_size' => 4.5,
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
						'palette' => $palette
					)
				);
Configure::write('Typographer.Backstage.used_automatic_classes', $used_automatic_classes);
?>