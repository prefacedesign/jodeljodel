<?php //aqui vão as rules de CSS 
	
	$this->Decorator->rule(
		'.box_container', array(
			'float' => 'left'
	));
	
	$this->Decorator->rule(
		'.box',	array(
			'float' => 'left',
			'margin-left' => $hg->size(array('g' => 1))
	));
	
	$this->Decorator->rule(
		'.float_break', 
		array(
			'clear' => 'both'
		)
	);
	
	$this->Decorator->rule(
		'*',
		array(
			'border' => 'none',
			'margin' => '0',
			'padding' => '0',
			'text-decoration' => 'none',
			'font-family' => '"Lucida Sans", "Bitstream Vera Sans"'
		)
	);
	
	$this->Decorator->rule(
		'body',
		array(
			//'background-color' => $palette['menu_bg']->write(),
			'font-size'        => $u->t(floor($line_height * 13/18)),
			'line-height'      => $u->t($line_height),
			'color'            => $palette['text']->write(),
			'background-image' => "url('". $ig->url(
				array(
						'w' => $hg->size(array('g' => 1/3)),
						'h' => $hg->size(array('g' => 1/3)),
						'iw' => 92,
						'ih' => 92,
						'base_name' => 'backstage_background',
						'layers' => array(
							array(
								'type' => 'apply_color', 
								'color' => $palette['menu_bg']
							),
							array(
								'type' => 'tint_image',
								'path' => '/img/matrixes/backstage_bg.png',
								'color' => $palette['bg_diagonal_lines']
							)
						)
					)
				)	
				.  "')"
		)
	);
	
	$box_shadow = '0 0 2px 2px ' .  $palette['shadows']->write();	
	$this->Decorator->rule(
		'#main_column',
		array(
			'background-color' => $palette['menu_bg']->write(),
			'border' => $u->t(1) . ' solid ' . $palette['bg']->write(),
			'border-top' => '0',
			'width' => $hg->size(array('M' => 12, 'g' => 1)),
			'margin' => 'auto',
			'box-shadow' => $box_shadow,
			'-webkit-box-shadow' => $box_shadow,
			'-moz-box-shadow' => $box_shadow
		)
	);
	
	$this->Decorator->rule(
		'#header',
		array(
			'width' => 'auto',
			'height' => $vg->size(array('g' => 6))
		)
	);
	
	$this->Decorator->rule(
		'#header div.box', array(
			'height' => $vg->size(array('g' => 5)),
			'background-image' => "url('". $ig->url(
				array(
						'w' => $hg->size(array('g' => (5/2)*3.743)),
						'h' => $hg->size(array('g' => 5/2)),
						'iw' => 826,
						'ih' => 218,
						'base_name' => 'backstage_site_logo',
						'layers' => array(
							array(
								'type' => 'apply_color', 
								'color' => $palette['menu_bg']
							),
							array(
								'type' => 'tint_image',
								'path' => '/img/matrixes/site_logo.png',
								'color' => $palette['text']
							)
						)
					)
				)	
				.  "')",
			'background-repeat' => 'no-repeat',
			'background-position' => '0 '. $vg->size(array('g' => (3 - 5/2)))
	));
	
	$this->Decorator->rule(
		'#header em', array(
			'font-style' => 'normal',
			'font-weight' => 'bold'
	)); 
	
	$this->Decorator->rule(
		'#header div.box p', array(
			'margin-top' => $vg->size(array('g' => '3', 'm' => 1))
	));
	
	$this->Decorator->rule(
		'#user_area', array(
			'background-color' => $palette['meta_menu_bg']->write(),
			'margin-top' => $vg->size(array('g' => 1)),
			'width' => $hg->size(array('M' => '4')),
			'height' => $vg->size(array('g' => '2')),
			'float' => 'right'
	));
	
	$this->Decorator->rule(
		'#user_area p', array(
			'display' => 'block',
			'float' => 'left',
			'margin-left' => $hg->size(array('g' => 1)),
			'margin-top' => $hg->size(array('m' => 2))
	));
	$this->Decorator->rule(
		'#user_area a', array(
			'display' => 'block',
			'float' => 'right',
			'margin-right' => $hg->size(array('g' => 1)),
			'margin-top' => $hg->size(array('m' => 2))
	));
	
	$this->Decorator->rule(
		'#footer', array(
			'width' => 'auto',
			'height' => $vg->size(array('g' => 2))
	));
	
	$this->Decorator->rule(
		'#content',
		array(
			'width' => 'auto',
			'background-color' => $palette['bg']->write(),
			'border-top' => $u->t(1) . ' solid ' . $palette['menu_border']->write(),
			'padding' => $vg->size(array('g' => 1)) . ' 0 ' . $vg->size(array('g' => 2)) . ' 0'
		)
	);
	
	$this->Decorator->rule(
		'#footer div.box',
		array(
			'margin-top' => $vg->size(array('m' => 2))
		)
	);
	
	$this->Decorator->rule(
		'#credits',
		array(
			'text-align' => 'right'
		)
	);
	
	$this->Decorator->rule(
		'a',
		array(
			'border-bottom' => $u->t(1) . ' solid ' . $palette['text']->write(),
			'color' => $palette['text']->write(),
		)
	);
	
	$this->Decorator->rule(
		'a:visited',
		array(
			'color' => $palette['visited_links']->write(),
			'border-color' => $palette['visited_links']->write()
		)
	);
	
	$this->Decorator->rule(
		'a:hover, a:active',
		array(
			'color' => $palette['bg']->write(),
			'background-color' => $palette['text']->write(),
			'border-color' => $palette['text']->write()
		)
	);
	
	$this->Decorator->rule(
		'.h1div span', array(
			'float' => 'right',
			'margin-top' => $vg->size(array('m' => 1))
	));
	
	$this->Decorator->rule(
		'.h1div', array(
			'border-bottom' => $u->t(2) . ' solid ' . $palette['text']->write(),
			'padding-bottom' => $vg->size(array('m' => 2)),
			'margin-bottom' => $vg->size(array('g' => 1.5))
	));
	
	$this->Decorator->rule(
		'h1', array(
			'font-size' => $u->t($line_height * 18/18),
			'line-height' => $u->t($line_height * 18/18),
			'font-weight' => 'normal'
	));
	
	$this->Decorator->rule(
		'.control_box', array(
			'background-color' => $palette['control_box_bg']->write(),
			'color' => $palette['control_box_fg']->write(),
			'float'	=> 'left',
			'width' => '100%',
			'margin-top' => $vg->size(array('g' => 1)),
			'margin-bottom' => $vg->size(array('g' => 1))
	));
	
	$this->Decorator->rule(
		'.control_box div', array(
			'margin' => $vg->size(array('g' => 1/3)) . ' ' . $hg->size(array('m' => 2))
	));
	
	$this->Decorator->rule(
		'.control_box h3', array(
			'font-size' => $u->t($line_height * 13/18),
			'line-height' => $u->t($line_height)
	));
	
	$this->Decorator->rule(
		'.control_box h3 span', array(
			'text-transform' => 'uppercase'
	));
	
	$this->Decorator->rule(
		'.small_text', array(
			'font-size' => $u->t($line_height * 11/18)
	));
	
	$this->Decorator->rule(
		'.control_box a',
		array(
			'color' => $palette['control_box_fg']->write(),
			'border-color' =>  $palette['control_box_fg']->write()
		)
	);
	
	$this->Decorator->rule(
		'.control_box a:visited',
		array(
			'color' => $palette['control_box_fg']->write(),
			'border-color' =>  $palette['control_box_fg']->write()			
		)
	);
	
	$this->Decorator->rule(
		'.control_box a:hover, .control_box a:active',
		array(
			'color' => $palette['control_box_bg']->write(),
			'background-color' => $palette['control_box_fg']->write(),
			'border-color' =>  $palette['control_box_bg']->write()
		)
	);
	
	$this->Decorator->rule(
		'.buro_form', array(
			'float' => 'left',
			'width' => '100%'
	));
	
	$this->Decorator->rule(
		'.buro_form div.input', array(
			'border-top' => $u->t(1) . ' solid ' . $palette['text'] ->write(),
			'margin-bottom' => $vg->size(array('g' => 2))
	));
	
	$this->Decorator->rule(
		'.buro_form label', array(
			'font-weight' => 'bold',
			'text-transform' => 'uppercase',
			'line-height' => $u->t($line_height * 4/3),
			'letter-spacing' => '0.135ex',
			'display' => 'block'
	));
	
	$this->Decorator->rule(
		'.buro_form .instructions', array(
			'font-size' => $u->t($line_height * 11/18),
			'font-style' => 'italic',
			'display'	=> 'block'
	));
	
	$border_size = 1;
	$padding_size = $hg->size(array('m' => 2), false);
	$margin_top = $vg->size(array('m' => 1), false);
	$padding_top = $vg->size(array('m' => 1), false);
	$this->Decorator->rule(
		'.buro_form input, .buro_form textarea', array(
			'border' => $u->t($border_size) . ' solid ' .  $palette['input_borders']->write(),
			'background-color' => $palette['input_bg']->write(),
			'color'	=> $palette['input_fg']->write(),
			'width' => $u->t($hg->size(array('M' => 5, 'g' => -1),false) - 2*($border_size + $padding_size)),
			'padding' => $u->t($padding_top) . ' ' . $u->t($padding_size),
			'margin-top' => $u->t($margin_top),
			'margin-bottom' => $u->t($vg->size(array('g' => 0.5),false) - $margin_top),
			'font-size' => $u->t($line_height * 13/18),
			'line-height' => $u->t($line_height)
	));
	
	$this->Decorator->rule(
		'.buro_form textarea', array(
			'height' => $vg->size(array('g' => 8.5, 'u' => -2*$border_size - $padding_top))
	));
	
	$this->Decorator->rule(
		'.buro_form input[type="text"]', array(
			'height' => $u->t($vg->size(array('g' => 1.5),false) - 2*$border_size - $padding_top)
	));
	
	$this->Decorator->rule(
		'.buro_form .superfield h6', array(
			'font-weight' => 'bold',
			'text-transform' => 'uppercase',
			'line-height' => $u->t($line_height * 4/3),
			'font-size' => $u->t($line_height * 13/18),
			'letter-spacing' => '0.135ex',
			'display' => 'block'
	));
	
	$this->Decorator->rule(
		'.buro_form .superfield label', array(
			'text-transform' => 'none',
			'font-size' => $u->t($line_height * 13/18),
			'line-height' => $u->t($line_height),
			'margin-top' => $hg->size(array('m' => 2)),
			'font-style' => 'bold',
			'display'	=> 'block',
			'letter-spacing' => '0'
	));
	
	$this->Decorator->rule(
		'button', array(
			''
	));

	$this->Decorator->rule(
		'.info_box', array(
			'background-color' => $palette['info_box_bg']->write(),
			'color' => $palette['info_box_fg']->write(),
			'float'	=> 'left',
			'width' => '100%',
			'margin-top' => $vg->size(array('g' => 1)),
			'margin-bottom' => $vg->size(array('g' => 1))
	));

	$this->Decorator->rule(
		'.info_box h3', array(
			'font-size' => $u->t($line_height * 13/18),
			'line-height' => $u->t($line_height)
	));

	$this->Decorator->rule(
		'.info_box p', array(
			'font-size' => $u->t($line_height * 13/18),
			'line-height' => $u->t($line_height)
	));
	
	/** Some common parameters used in many rules
	 */
	$border_width = $hg->size(array('u'=> 1), false);
	$outer_border = $u->t($border_width) . ' solid ' . $palette['text']->write();
	$cell_padding_left  = $hg->size(array('m'=> 2),false);
	$cell_padding_right = $hg->size(array('m'=> 1), false);
	
	$this->Decorator->rule(
		'table.dashboard', array(
			'border-spacing' => 0,
			'border-collapse' => 'collapse',
			'text-align' => 'left',
			'border-bottom' => $outer_border,
			'border-top' => $outer_border,
			'font-size' => $vg->size(array('u' => ($line_height * 11/18)))
	));
	
	$this->Decorator->rule(
		'table.dashboard th', array(
			'background-color' => $palette['control_box_bg']->write(),
			'color' => $palette['control_box_fg']->write(),
			'height' => $vg->size(array('m' => 6))
	));
	
	$this->Decorator->rule(
		'table.dashboard td, table.dashboard th', array(
			'padding-left' => $u->t($cell_padding_left),
			'padding-right' => $u->t($cell_padding_right),
			'padding-bottom' => $vg->size(array('m'=> 1.5)),
			'vertical-align' => 'text-top',
			'text-align' => 'left'
	));
	
	$this->Decorator->rule(
		'table.dashboard tr', array(
			'border-left' => $outer_border,
			'border-right' => $outer_border
	));
	
	$this->Decorator->rule(
		'tr.extra_info, tr.actions', array(
			'display' => 'none'
	));
	
	$this->Decorator->rule(
		'tr.expanded.extra_info, tr.expanded.actions', array(
			'display' => 'table-row'
	));
	
	$this->Decorator->rule(
		'tr.main_info.expanded', array(
			'border-top' => $vg->size(array('u'=> 4)) . ' solid ' . $palette['internal_selection']->write()
	));
	
	$this->Decorator->rule(
		'table.dashboard tr.actions.expanded', array(
			'border-bottom' => $vg->size(array('u'=> 4)) . ' solid ' . $palette['internal_selection']->write()
	));
	
	$this->Decorator->rule(
		'table.dashboard tr.expanded', array(
			'border-left' => $hg->size(array('u'=> 4)) . ' solid ' . $palette['internal_selection']->write(),
			'border-right' => $hg->size(array('u'=> 4)) . ' solid ' . $palette['internal_selection']->write()
	));
	
	$this->Decorator->rule(
		'table.dashboard tr.main_info, table.dashboard tr.actions', array(
			'border-bottom' => $u->t($border_width) . ' dashed ' . $palette['text']->write()
	));
	
	$this->Decorator->rule(
		'table.dashboard td', array(
			'padding-top' => $vg->size(array('m'=> 2))
	));
	
	$this->Decorator->rule(
		'table.dashboard th', array(
			'padding-top' => $vg->size(array('m'=> 1.5)),
			'border-right' => $u->t($border_width) . ' solid ' . $palette['control_box_fg']->write()
	));
	
	$this->Decorator->rule(
		'table.dashboard th.last_col', array(
			'border-right' => $u->t($border_width) . ' solid ' . $palette['text']->write()
	));
	
	$this->Decorator->rule(
		'table.dashboard th.col_1', array(
			'width' => $hg->size(array('M' => 1, 'm' => -2, 'u' => (-$cell_padding_right - $cell_padding_left - 2 * $border_width)))
	));
	
	$this->Decorator->rule(
		'table.dashboard th.col_2', array(
			'width' => $hg->size(array('M' => 1, 'u' => (-$cell_padding_right - $cell_padding_left - 2 * $border_width)))
	));
	
	$this->Decorator->rule(
		'table.dashboard th.col_3', array(
			'width' => $hg->size(array('M' => 4, 'u' => (-$cell_padding_right - $cell_padding_left - 2 * $border_width)))
	));
	
	$this->Decorator->rule(
		'table.dashboard th.col_4', array(
			'width' => $hg->size(array('M' => 3, 'u' => (-$cell_padding_right - $cell_padding_left - 2 * $border_width)))
	));
	
	$this->Decorator->rule(
		'table.dashboard th.col_5', array(
			'width' => $hg->size(array('M' => 1, 'u' => (-$cell_padding_right - $cell_padding_left - 2 * $border_width)))
	));
	
	$this->Decorator->rule(
		'table.dashboard th.col_6', array(
			'width' => $hg->size(array('M' => 1, 'u' => (-$cell_padding_right - $cell_padding_left - 2 * $border_width)))
	));
	
?>
