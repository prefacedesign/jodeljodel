<?php //aqui vão as rules de CSS 
	
//.caixa_popup{border: 2px solid black; background: white; padding: 10px; position: absolute; z-index: 100; width: 400px;}
//.caixa_popup .callbacks{float: right;}

//.carregando{background: url(/popup/img/load.gif) no-repeat center center; width: 20px; height: 20px;}

//.caixa_popup .carregando{position: absolute; top: 0; right: 0;}
//.caixa_popup .barra_de_progresso{height: 40px; background: #d8d9db; margin-top: 10px;}
//.caixa_popup .enchimento_da_barra{height: 40px; background: #009be8; width: 0;}

//.velatura_popup{background: black; position: fixed; width: 100%; height: 100%; z-index: 99; left: 0; top: 0;}

	$this->Decorator->rule(
		'.box_popup', array(
			'z-index' => '100',
			'border' => '2px solid black',
			'position' => 'absolute',
			'width' => $vg->size(array('M' => 7, 'g' => -1)),
			'padding' => $hg->size(array('g' => 1, 'm' => 1)) . ' 0'
	));
	
	$this->Decorator->rule(
		'.box_popup h2', array(
			'font-size' => $u->t($line_height * 13/18),
			'font-weight' => 'bold',
			'text-transform' => 'uppercase',
			'letter-spacing' => '0.135ex',
			'margin-bottom' => $vg->size(array('g' => 1))
	));
	
	$this->Decorator->rule(
		'.box_popup .callbacks', array(
			'margin-top' => $vg->size(array('g' => 1.5))
	));
	$this->Decorator->rule(
		'.box_popup .callbacks a', array(
			'padding-left' => $hg->size(array('m' => 2)),
			'padding-right' => $hg->size(array('m' => 2)),
			'text-transform' => 'uppercase',
			'letter-spacing' => '0.13ex',
			'font-weight' => 'bold'	
	));
	
	$this->Decorator->rule(
		'a.link_button', array(
			'background-color' => $palette['button_bg']->write(),
			'height' => $vg->size(array('g' => 1.2)),
			'border' => '1px solid black !important',
			'border-radius' => '7px',
			'-webkit-border-radius' => '7px',
			'-moz-border-radius' => '7px',
			'display' => 'block',
			'float' => 'left',
			'text-align' => 'center',
			'padding-top' => $vg->size(array('m' => 1)),
			'color' => $palette['text']->write(),
			'margin-right' => $hg->size(array('m' => 2)),
	));
	
	$this->Decorator->rule(
		'a.link_button:visited', array(
			'color' => $palette['text']->write(),
	));
	
	$this->Decorator->rule(
		'a.link_button:hover', array(
			'background-color' => $palette['hover_button_bg']->write(),
			'color' => $palette['text']->write(),
	));
	
	$this->Decorator->rule(
		'a.link_button:active', array(
			'color' => $palette['bg']->write(),
			'background-color' => $palette['active_button_bg']->write(),
	));
	
	
	
	
	$this->Decorator->rule(
		'.error_box', array(
			'background' => $palette['error_popin']->write(),
	));
	
	$this->Decorator->rule(
		'.success_box', array(
			'background' => $palette['normal_popin']->write(),
	));
	
	$this->Decorator->rule(
		'.popup_maya_veil', array(
			'background' => 'black',
			'position' => 'fixed',
			'width' => '100%',
			'height' => '100%',
			'z-index' => '99',
			'left' => 0,
			'top' => 0
	));
	
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
		'.control_box .alternative_option',
		array(
			'float' => 'left',
			'margin' => $vg->size(array('m' => 6)) . ' 0 ' . $vg->size(array('m' => 2)) . ' ' . $vg->size(array('m' => 1)),
		)
	);
	
	$this->Decorator->rule(
		'.dashboard th a, .control_box a',
		array(
			'color' => $palette['control_box_fg']->write(),
			'border-color' =>  $palette['control_box_fg']->write()
		)
	);
	
	$this->Decorator->rule(
		'.dashboard th a:visited, .control_box a:visited',
		array(
			'color' => $palette['control_box_fg']->write(),
			'border-color' =>  $palette['control_box_fg']->write()			
		)
	);
	
	$this->Decorator->rule(
		'.dashboard th a:hover, .dashboard th a:active, .control_box a:hover, .control_box a:active',
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
			'padding-bottom' => $vg->size(array('g' => 2))
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
	
	$padding_left = $hg->size(array('m' => 0.75), false);
	$this->Decorator->rule(
		'.pagination span', array(
			'display' => 'block',
			'float' => 'left',
			'text-align' => 'right',
			'margin-left' => $hg->size(array('m' => 0.75)),
			'min-width' => $hg->size(array('m' => 4.5, 'u' => $u->t(-$padding_left))),
			'padding' => $hg->size(array('m' => 0.5)) . ' ' . $u->t( $padding_left),
			'border' => $hg->size(array('u' => 1)) . ' solid ' .  $palette['menu_border']->write(),
			'font-weight' => 'bold'
	));
	
	$this->Decorator->rule(
		'.pagination span.current', array(
			'border-color' => $palette['internal_selection']->write(),
			'background-color' => $palette['internal_selection']->write(),
			'background-color' => $palette['internal_selection']->write(),
	));
	
	
	
	$this->Decorator->rule(
		'body div.pagination span a, body div.pagination span a:hover, body div.pagination span a:visited, body div.pagination span a:hover', array(
			'border' => 0,
			'color' => $palette['text']->write(),
			'background' => 'transparent'
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
		'button.submit.buro', array(
			'-moz-border-radius'  => '5px',
			'border-radius' => '5px',
			'-webkit-border-radius' => '5px',
			'background-color' => $palette['button_bg']->write(),
			'color' => $palette['text']->write(),
			'float' => 'left',
			'font-style' => 'normal !important',
			'font-weight' => 'bold',
			'font-size' => $u->t($line_height * 13/18),
			'padding-left' => $vg->size(array('m' => 2)),
			'padding-right' => $vg->size(array('m' => 2)),
			'text-align' => 'left',
			'text-transform' => 'uppercase',
			'height' => $hg->size(array('g' => 1.4)),
			'margin' => $vg->size(array('m' => 5)) . ' 0 ' . $vg->size(array('m' => 2)) . ' 0',
			'letter-spacing' => '0.1ex'
	));
	
	$this->Decorator->rule(
		'.error-message', array(
			'color' => $palette['error_message']->write(),
			'font-size' => $u->t($line_height * 11/18),
			'font-weight' => 'bold',
			'font-style' => 'italic'
	));
	
	$this->Decorator->rule(
		'.subinput input.form-error', array(
			'background-color' => $palette['input_error_bg']->write(),
			'color' => $palette['input_error_fg']->write(),
	));
	$this->Decorator->rule(
		'.input.error', array(
			'background-color' => $palette['input_error_bg']->write(),
	));
	
	$this->Decorator->rule(
		'.error label', array(
			'color' => $palette['error_message']->write(),
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
			'width' => '100%',
			'font-size' => $vg->size(array('u' => ($line_height * 11/18)))
	));
	
	//First IE specific:
	if ($browserInfo['name'] == 'Internet Explorer' && $browserInfo['version'] < 9)
	{
		$this->Decorator->rule(
			'table.dashboard', array(
				'table-layout' => 'fixed',
		));
	}
	
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
			'width' => $hg->size(array('M' => 1, 'u' => (-$cell_padding_right - $cell_padding_left - $border_width)))
	));
	
	$this->Decorator->rule(
		'table.dashboard th.col_3', array(
			'width' => $hg->size(array('M' => 4, 'u' => (-$cell_padding_right - $cell_padding_left - $border_width)))
	));
	
	$this->Decorator->rule(
		'table.dashboard th.col_4', array(
			'width' => $hg->size(array('M' => 3, 'u' => (-$cell_padding_right - $cell_padding_left - $border_width)))
	));
	
	$this->Decorator->rule(
		'table.dashboard th.col_5', array(
			'width' => $hg->size(array('M' => 1, 'u' => (-$cell_padding_right - $cell_padding_left - $border_width)))
	));
	
	$this->Decorator->rule(
		'table.dashboard th.col_6', array(
			'width' => $hg->size(array('M' => 1, 'u' => (-$cell_padding_right - $cell_padding_left - $border_width)))
	));
	
	$this->Decorator->rule(
		'table.dashboard th.col_7', array(
			'width' => $hg->size(array('M' => 1, 'm' => -2, 'u' => (-$cell_padding_right - $cell_padding_left - 2 * $border_width)))
	));
	
	$arrow_size = $hg->size(array('m' => 3), false);
	
	$this->Decorator->rule(
		'div.arrow', array(
			'position' => 'relative'
	));
	
	$this->Decorator->rule(
		'.arrow a', array(
			'border' => 0,
			'position' => 'absolute',
			'right' => $u->t(-$arrow_size+2),
			'top' => $vg->size(array('u' => 3)),
			'width' => $u->t($arrow_size),
			'height' => $u->t($arrow_size),
			'background-repeat' => 'no-repeat',
			'background-color' => 'transparent',
			'background-image' => "url('". $ig->url(
				array(
						'w' => $arrow_size,
						'h' => $arrow_size,
						'iw' => 101,
						'ih' => 101,
						'base_name' => 'dashboard_arrow',
						'layers' => array(
							array(
								'type' => 'apply_color', 
								'color' => $palette['bg']
							),
							array(
								'type' => 'tint_image',
								'path' => '/img/matrixes/dashboard_arrow_down_1.png',
								'color' => $palette['button_bg']
							),
							array(
								'type' => 'tint_image',
								'path' => '/img/matrixes/dashboard_arrow_down_2.png',
								'color' => $palette['text']
							)
						)
					)
				)	
				.  "')"
	));
	
	$this->Decorator->rule(
		'div.arrow a:active, div.arrow a:hover', array(
			'border' => 0
	));
	
	$this->Decorator->rule(
		'.expanded .arrow a', array(
			'background-image' => "url('". $ig->url(
				array(
						'w' => $arrow_size,
						'h' => $arrow_size,
						'iw' => 101,
						'ih' => 101,
						'base_name' => 'dashboard_arrow_up',
						'layers' => array(
							array(
								'type' => 'apply_color', 
								'color' => $palette['bg']
							),
							array(
								'type' => 'tint_image',
								'path' => '/img/matrixes/dashboard_arrow_up_1.png',
								'color' => $palette['button_bg']
							),
							array(
								'type' => 'tint_image',
								'path' => '/img/matrixes/dashboard_arrow_up_2.png',
								'color' => $palette['text']
							)
						)
					)
				)	
				.  "')"
	));
	
	$this->Decorator->rule(
		'table.dashboard a.link_button', array(
			'font-size' => $u->t($line_height * 13/18),
			'padding-left' => $hg->size(array('m' => 1)),
			'padding-right' => $hg->size(array('m' => 1))
	));
	
	$this->Decorator->rule(
		'table.dashboard tr.actions td, table.dashboard tr.actions td *', array(
			'vertical-align' => 'text-bottom'
	));
	
	$this->Decorator->rule(
		'table.dashboard tr.actions td, table.dashboard tr.actions div', array(
			'position' => 'relative',
			'height' => '100%',
			'bottom' => $hg->size(array('m' => 0.8))
	)); 
	
	$this->Decorator->rule(
		'table.dashboard th', array(
			'font-weight' => 'bold',
			'text-transform' => 'uppercase',
			'letter-spacing' => '0.135ex'
	));
	
?>
