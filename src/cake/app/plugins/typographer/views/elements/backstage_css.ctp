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


	$this->Decorator->rule(
		'html', array(
			'overflow-y' => 'scroll'
		)
	);
	

	$this->Decorator->rule('.loading',
		array(
			'min-height' => $u->t(53)
		)
	);

	$box_shadow = '0 0 2px 2px ' .  $palette['shadows']->write();
	$img_url = $this->Decorator->url('/burocrata/img/loading.gif');
	$this->Decorator->rule('.loading-indicator',
		array(
			'background' => sprintf('%s url(%s) no-repeat', $palette['bg']->write(), $img_url),
			'height' => $u->t(13),
			'width' => $u->t(45),
			'position' => 'absolute',
			'z-index' => 10001,
			'box-shadow' => $box_shadow,
			'-webkit-box-shadow' => $box_shadow,
			'-moz-box-shadow' => $box_shadow
		)
	);
	$this->Decorator->rule('.loading-overlayer',
		array(
			'background-color' => 'white',
			'position' => 'absolute',
			'z-index' => 10000,
			'min-height' => $u->t(60)
		)
	);
	
	
	$border_size = 1;
	$width = $hg->size(array('M' => 5, 'g' => -1), false) - 2*$border_size;
	
	$this->Decorator->rule(
		'.autocomplete.list', array(
			'z-index' => 1000,
			'background-color' => $palette['menu_bg']->write(),
			'border' => $u->t(1) . ' solid ' . $palette['menu_border']->write(),
			'margin-top' => $u->t(-2),
			'width' => $u->t($width) . ' !important',
	));
	
	$this->Decorator->rule(
		'.autocomplete.list ul', array(
			'list-style-type' => 'none'
	));
	
	$this->Decorator->rule(
		'.autocomplete.list ul li', array(
			'height' => 'auto',
			'border-bottom' => $u->t(1) . ' dotted ' . $palette['text']->write(),
			'cursor' => 'pointer',
			'padding-left' => $hg->size(array('m' => 2)),
			'padding-top' => $hg->size(array('m' => 1)),
			'display' => 'block'
	));
	
	$this->Decorator->rule(
		'.autocomplete.list .message a', array(
			'height' => $vg->size(array('g' => 1, 'm' => 1)),
			'display' => 'block',
			'background-color' => $palette['text']->write(),
			'color' => $palette['bg']->write(),
			'padding-left' => $hg->size(array('m' => 2)),
			'padding-top' => $hg->size(array('m' => 1)),
			'font-weight' => 'bold',
	));
	
	$this->Decorator->rule(
		'.autocomplete.list .message a:hover, .autocomplete.list .message a:active', array(
			'background-color' => $palette['text']->write(),
			'color' => $palette['bg']->write(),
	));
	
	
	// Input Many Children AND ContentStream
	
	$this->Decorator->rule(
		'.many_children .buro_form, .content_stream .buro_form', array(
			'background-color' => $palette['subform']->write(),
			'margin' => sprintf('%s %s', $hg->size(array('g' => 1)), 0),
			'margin-left' => $hg->size(array('g' => -1)),
			'padding' => sprintf('%s %s', $vg->size(array('g' => 0.5)), $hg->size(array('g' => 1)))
	));
	
	$this->Decorator->rule(
		'.many_children .buro_form .buro_form, .content_stream .buro_form .buro_form', array(
			'background-color' => $palette['subform2']->write(),
	));
	
	$this->Decorator->rule(
		'.many_children .buro_form div.input, .content_stream .buro_form div.input', array(
			'border' => 0,
			'padding-bottom' => $vg->size(array('g' => 0.5))
	));
	
	$this->Decorator->rule(
		'.many_children .buro_form label.buro, .content_stream .buro_form label.buro', array(
			'text-transform' => 'none'
	));
	
	$this->Decorator->rule(
		'.many_children button, .content_stream button', array(
			'overflow' => 'hidden',
			'position' => 'relative',
			'cursor' => 'pointer'
	));

	$this->Decorator->rule(
		'.many_children button[disabled], .content_stream button[disabled]', array(
			'cursor' => 'default'
	));
	
	$this->Decorator->rule(
		'.many_children button span, .content_stream button span', array(
			'top' => '100%',
			'position' => 'absolute',
	));
	
	
	
	$this->Decorator->rule(
		'.ordered_list_content hr', array(
			'border' => '1px solid black'
	));
	
	$this->Decorator->rule(
		'.ordered_list_item', array(
			'margin' => sprintf('%s %s', $hg->size(array('g' => 0.5)), 0)
	));
	
	$this->Decorator->rule(
		'.many_children .ordered_list_item.auto_order', array(
			'padding-bottom' => $hg->size(array('g' => 0.5)),
			'border-bottom' => '1px dashed black'
	));
	
	$this->Decorator->rule(
		'.many_children .ordered_list_item.auto_order.last_item', array(
			'border-bottom' => '0px'
	));
	
	$arrow_size = 13;
	$img_url = $ig->url(array(
			'iw' => 427, 'w' => $arrow_size*3+15,
			'ih' => 206, 'h' => $arrow_size*2,
			'base_name' => 'burocrata_list_of_items',
			'layers' => array(
				array('type' => 'apply_color', 'color' => $palette['bg']),
				array('type' => 'tint_image',  'color' => $palette['button_bg'],		  'path' => '/img/matrixes/burocrata_list_of_items_1.png'),
				array('type' => 'tint_image',  'color' => $palette['text'],				  'path' => '/img/matrixes/burocrata_list_of_items_2.png'),
				array('type' => 'tint_image',  'color' => $palette['button_bg_disabled'], 'path' => '/img/matrixes/burocrata_list_of_items_1.png', 'pos' => array('y' => 103)),
				array('type' => 'tint_image',  'color' => $palette['button_fg_disabled'], 'path' => '/img/matrixes/burocrata_list_of_items_2.png', 'pos' => array('y' => 103)),
			)
		)
	);
	
	$this->Decorator->rule(
		'.pie_text p+p', array(
			'margin-top' => $u->t($line_height)
	));
	
	
	// Ordered List
	
	$this->Decorator->rule(
		'.ordered_list_menu', array(
			'position' => 'relative',
			'clear' => 'both'
	));
	
	$this->Decorator->rule(
		'.ordered_list_menu .ordered_list_menu_list', array(
			'background-color' => $palette['subform']->write(),
			'margin-left' => $hg->size('-g'),
			'padding' => sprintf('%s %s', 0, $hg->size('g')),
			'line-height' => $u->t($line_height*1.5),
			'width' => '100%'
	));
	
	$this->Decorator->rule(
		'.ordered_list_menu span.caption', array(
			'text-transform' => 'uppercase'
	));
	
	$this->Decorator->rule(
		'.ordered_list_menu .ordered_list_menu_list_list', array(
			'float' => 'right',
			'max-width' => $hg->size('5M')
	));
	
	$this->Decorator->rule(
		'.ordered_list_menu .border', array(
			'border-top' => '1px dashed black',
			'margin-top' => '-1px'
	));
	
	$bg_pos = $u->t(15);
	$this->Decorator->rule(
		'.ordered_list_menu button.ordered_list_menu_add', array(
			'background' => sprintf('transparent url(%s) repeat scroll %s top', $img_url, $bg_pos),
			'height' => $u->t($arrow_size),
			'width' => $u->t(15),
			'position' => 'absolute',
			'right' => $u->t(-15),
			'top' => $u->t(-ceil($arrow_size/2))
	));
	
	$this->Decorator->rule(
		'.ordered_list_menu button.ordered_list_menu_add[disabled]', array(
			'background-position' => sprintf('%s bottom', $bg_pos)
	));
	
	
	$this->Decorator->rule(
		'.ordered_list_controls', array(
			'margin-bottom' => $vg->size(array('g' => 0.5)),
			'font-size' => '11px',
			'float' => 'left'
	));
	
	$this->Decorator->rule(
		'.ordered_list_item_title', array(
			'color' => $palette['subitem_title']->write(),
			'float' => 'right',
			'font-size' => $u->t($line_height * 11/18),
			'font-weight' => 'bold',
			'text-transform' => 'uppercase'
	));
	
	$this->Decorator->rule(
		'.ordered_list_controls button', array(
			'vertical-align' => 'middle'
	));
	
	$bg_pos = $u->t(15+$arrow_size*1);
	$this->Decorator->rule(
		'.ordered_list_controls .ordered_list_delete', array(
			'background' => sprintf('transparent url(%s) repeat scroll %s top', $img_url, $bg_pos),
			'height' => $u->t($arrow_size),
			'width' => $u->t($arrow_size),
	));
	$this->Decorator->rule(
		'.ordered_list_controls .ordered_list_delete[disabled]', array(
			'background-position' => sprintf('%s bottom', $bg_pos)
	));
	
	$bg_pos = $u->t(15+$arrow_size*2);
	$this->Decorator->rule(
		'.ordered_list_controls .ordered_list_up', array(
			'background' => sprintf('transparent url(%s) repeat scroll %s top', $img_url, $bg_pos),
			'height' => $u->t($arrow_size),
			'width' => $u->t($arrow_size),
	));
	$this->Decorator->rule(
		'.ordered_list_controls .ordered_list_up[disabled]', array(
			'background-position' => sprintf('%s bottom', $bg_pos)
	));

	$this->Decorator->rule(
		'.ordered_list_controls .ordered_list_down', array(
			'background' => sprintf('transparent url(%s) repeat scroll %s top', $img_url, 0),
			'height' => $u->t($arrow_size),
			'width' => $u->t($arrow_size),
	));
	$this->Decorator->rule(
		'.ordered_list_controls .ordered_list_down[disabled]', array(
			'background-position' => sprintf('%s bottom', 0)
	));
	

	// Input belongsTo
	$this->Decorator->rule(
		'.input_relational .controls div div.buro_form', array(
			'background-color' => $palette['subform']->write(),
			'margin' => sprintf('%s %s', $hg->size(array('g' => 1)), 0),
			'margin-left' => $hg->size(array('g' => -1)),
			'padding' => sprintf('%s %s', $vg->size(array('g' => 0.5)), $hg->size(array('g' => 1)))
	));
	
	$this->Decorator->rule(
		'.input_relational .controls div.buro_form div.buro_form, .ordered_list .input_relational div.buro_form', array(
			'background-color' => $palette['subform2']->write() . ' !important',
	));
	
	$this->Decorator->rule(
		'.input_relational .controls div div div.buro_form, .ordered_list .input_relational div.buro_form', array(
			'border-top' => '0 !important',
			'margin-top' => '0 !important',
			'padding-top' => '0 !important',
	));
	
	$this->Decorator->rule(
		'.input_relational .controls div div div.input', array(
			'padding-bottom' => '0',
			'border' => '0',
			//'position' => 'absolute',
	));
	
	
	
	// Input autocomplete
	
	$width -= $hg->size(array('m' => 2), false);
	$this->Decorator->rule(
		'.autocomplete.list .nothing_found', array(
			'height' => $vg->size(array('g' => 1, 'm' => 1)),
			'background-color' => $palette['input_error_bg']->write(),
			'color' => $palette['error_message']->write(),
			'border' => $u->t(1) . ' solid ' . $palette['error_message']->write(),
			'margin-top' => $u->t(-1),
			'width' => $u->t($width) . ' !important',
			'font-weight' => 'bold',
			'font-style' => 'italic',
			'padding-left' => $hg->size(array('m' => 2)),
			'padding-top' => $hg->size(array('m' => 1)),
			'margin-left' => $u->t(-1)
	));
	
	
	$this->Decorator->rule(
		'.autocomplete.list ul li.selected', array(
			'background-color' => $palette['selection']->write(),
	));
	
	
	
	// Color input
	$border_size = 1;
	$padding_top = $vg->size('m', false);
	$padding_size = $vg->size('2m', false);
	$sample_size = $hg->size('1.5g',false) - 2*$border_size - $padding_top;
	$this->Decorator->rule(
		'.input_color .sample', array(
			'height' => $u->t($sample_size),
			'width' => $u->t($sample_size),
			'border' => sprintf('%s solid black', $u->t($border_size)),
			'float' => 'left',
			'padding' => $u->t($padding_top),
			'margin-top' => $vg->size('m'),
			'margin-right' => $hg->size('m')
	));
	
	// Copied from 
	$input_width = $hg->size('5M-g',false) - 2*($border_size + $padding_size);
	$input_width -= $hg->size('1.5g',false) + 2*$border_size;
	$input_width -= $hg->size('m');
	$input_width -= 2;
	
	$this->Decorator->rule(
		'.input_color input', array(
			'width' => $u->t($input_width) . ' !important',
	));
	
	$this->Decorator->rule(
		'.error_box', array(
			'background' => $palette['error_popin']->write(),
	));
	
	$this->Decorator->rule(
		'.success_box, .notice_box, .form_box', array(
			'background' => $palette['normal_popin']->write(),
	));
	
	
	$box_shadow = '0 '.$vg->size(array('u' => 3)).' '. $vg->size(array('u' => 10)). ' ' . $palette['popin_shadow']->write();
	$this->Decorator->rule(
		'.box_popup', array(
			'z-index' => '1000',
			'border' => '1px solid white',
			'position' => 'absolute',
			'background' => 'white',
			'width' => $vg->size(array('M' => 7, 'g' => -1)),
			'padding' => $hg->size(array('g' => 1)) . ' 0',
			'box-shadow' => $box_shadow,
			'-webkit-box-shadow' => $box_shadow,
			'-moz-box-shadow' => $box_shadow
	));
	
	$this->Decorator->rule(
		'.popup_maya_veil', array(
			'background' => 'black',
			'position' => 'fixed',
			'width' => '100%',
			'height' => '100%',
			'z-index' => '999',
			'left' => 0,
			'top' => 0
	));
	
	$this->Decorator->rule(
		'.box_popup h2', array(
			'font-size' => $u->t($line_height * 13/18),
			'font-weight' => 'bold',
			'text-transform' => 'uppercase',
			'letter-spacing' => $letterSpacing,
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
			'letter-spacing' => $letterSpacing,
			'font-weight' => 'bold'
	));
	
	// form popup
	$this->Decorator->rule(
		'.box_popup.form_box p', array('margin-bottom' => $vg->size(array('g' => 1))));
	$this->Decorator->rule(
		'.box_popup.form_box label', array('text-transform' => 'none',));
	$this->Decorator->rule(
		'.box_popup.form_box input', array('margin-bottom' => $vg->size(array('g' => 1))));
	$this->Decorator->rule(
		'.box_popup.form_box .callbacks', array('margin-top' => $vg->size(array('g' => 0.5))));
	
	// progress popup
	$this->Decorator->rule(
		'.box_popup .popup_progress_bar', array(
			'margin-top' => $vg->size('g'),
			'height' => $vg->size('g'),
			'background' => $palette['menu_bg'],
		)
	);
	
	$this->Decorator->rule(
		'.box_popup .popup_progress_bar .popup_progress_bar_filler', array(
			'height' => $vg->size('g'),
			'background' => $palette['internal_selection'],
			'width' => 0
		)
	);
	
	
	
	$this->Decorator->rule(
		'a.link_button', array(
			'background-color' => $palette['button_bg']->write(),
			'height' => $vg->size(array('m' => 6)),
			'line-height' => $vg->size(array('m' => 6)),
			'border' => '1px solid black !important',
			'border-radius' => '5px',
			'-webkit-border-radius' => '5px',
			'-moz-border-radius' => '5px',
			'display' => 'block',
			'float' => 'left',
			'text-align' => 'center',
			'color' => $palette['text']->write(),
			'margin-right' => $hg->size(array('m' => 2)),
	));
	
	
	$this->Decorator->rule(
		'a.link_button:hover', array(
			'background-color' => $palette['button_bg_hover']->write(),
			'color' => $palette['text']->write(),
	));
	
	$this->Decorator->rule(
		'a.link_button:active', array(
			'color' => $palette['bg']->write(),
			'background-color' => $palette['button_bg_hover']->write(),
	));

	$this->Decorator->rule(
		'a.link_button.disabled, a.link_button.disabled:active, a.link_button.disabled:hover', array(
			'color' => $palette['button_fg_disabled'],
			'border-color' => $palette['button_fg_disabled'] . '!important',
			'background-color' => $palette['button_bg_disabled']
	));
	
	
	// Textile input
	
	$this->Decorator->rule(
		'.buro .input_textile .textarea_container', array(
			'margin-top' => $hg->size(array('m' => 2))
	));
	
	$this->Decorator->rule(
		'.buro .input_textile .textarea_container.focus', array(
			'margin-top' => $hg->size(array('m' => 2, 'u' => -1)) . ' !important'
	));
	
	
	$this->Decorator->rule(
		'a.link_button.buro_textile', array(
			'width' => $hg->size(array('M' => 1)),
			'height' => $vg->size(array('g' => 1)),
			'line-height' => $vg->size(array('g' => 1)),
			'overflow' => 'hidden',
			'margin-top' => $hg->size(array('m' => 1))
	));
	
	$this->Decorator->rule(
		'a.link_button.buro_textile.bold_textile', array(
			'font-weight' => 'bold'
	));
	
	$this->Decorator->rule(
		'a.link_button.buro_textile.ital_textile', array(
			'font-style' => 'italic'
	));
	
	$this->Decorator->rule(
		'a.link_button.buro_textile.link_textile, a.link_button.buro_textile.file_textile', array(
			'text-decoration' => 'underline'
	));
	
	$this->Decorator->rule(
		'div.buro_textile.preview', array(
			'max-height' => $hg->size(array('M' => 3)),
			'overflow' => 'auto'
	));
	
	
	$this->Decorator->rule(
		'.box_container', array(
			'float' => 'left'
	));
	
	$this->Decorator->rule(
		'.box',	array(
			'float' => 'left',
			'margin-left' => $hg->size('g')
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
			'font-family' => '"Lucida Sans", "Lucida Sans Std", "Bitstream Vera Sans", sans-serif'
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
			'margin-bottom' => $hg->size(array('g' => 1)),
			'box-shadow' => $box_shadow,
			'-webkit-box-shadow' => $box_shadow,
			'-moz-box-shadow' => $box_shadow
		)
	);
	
	$this->Decorator->rule(
		'#login_box',
		array(
			'background-color' => $palette['menu_bg']->write(),
			'border' => $u->t(1) . ' solid ' . $palette['bg']->write(),
			'width' => $hg->size(array('M' => 4, 'g' => 1)),
			'margin' => 'auto',
			'margin-top' => $vg->size(array('g' => 5)),
			'box-shadow' => $box_shadow,
			'-webkit-box-shadow' => $box_shadow,
			'-moz-box-shadow' => $box_shadow
		)
	);
	
	$this->Decorator->rule(
		'#login_box div#login_box_contained',
		array(
			'width' => $hg->size(array('M' => 4, 'g' => -1)),
			'margin' => $hg->size(array('g' => 1)),
		)
	);
	
	
	
	$this->Decorator->rule(
		'#header',
		array(
			'width' => 'auto',
#			'height' => $vg->size(array('g' => 6, 'u' => 2)),
			'position' => 'relative'
		)
	);
	
	$image_url = $ig->url(
		array(
				'w' => $hg->size(array('u' => 1600/4.844), false),
				'h' => $hg->size(array('g' => 5/2), false),
				'iw' => 1600,
				'ih' => 218,
				'base_name' => 'backstage_site_logo',
				'layers' => array(
					array('type' => 'apply_color',  'color' => $palette['menu_bg']),
					array('type' => 'tint_image', 'path' => '/img/matrixes/site_logo.png', 'color' => $palette['text'])
				)
			)
		); 
	$top = $vg->size(array('g' => (3 - 5/2)));
	
	$this->Decorator->rule(
		'#header #logo', array(
			'height' => $vg->size(array('g' => 5)),
			'background' => "transparent 0 $top url($image_url) no-repeat"
	));
	
	$this->Decorator->rule(
		'#header #logo em', array(
			'font-style' => 'normal',
			'font-weight' => 'bold'
	)); 
	
	$this->Decorator->rule(
		'#header #logo p', array(
			'margin-top' => $vg->size(array('g' => '3', 'm' => 1))
	));
	
	$this->Decorator->rule(
		'#user_area', array(
			'background-color' => $palette['meta_menu_bg']->write(),
			'margin-top' => $vg->size(array('g' => 1)),
			'height' => $vg->size(array('g' => '2')),
	));
	
	$this->Decorator->rule(
		'#user_area p', array(
			'float' => 'left',
			'margin-left' => $hg->size(array('g' => 1)),
			'margin-top' => $hg->size(array('m' => 2))
	));
	$this->Decorator->rule(
		'#user_area a', array(
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
			'background-color' => $palette['bg']->write(),
			'border-top' => $u->t(1) . ' solid ' . $palette['menu_border']->write(),
			'padding' => $vg->size(array('g' => 1)) . ' 0 ' . $vg->size(array('g' => 2)) . ' 0',
		)
	);
	
	$this->Decorator->rule(
		'#content #edit_page_title_draft a.disabled, #content #edit_page_title_published a.disabled',
		array(
			'color' => $palette['button_fg_disabled']->write(),
			'cursor' => 'text'
		)
	);
	
	$this->Decorator->rule(
		'#content #edit_page_title_draft a.disabled:hover, #content #edit_page_title_published a.disabled:hover',
		array(
			'color' => $palette['button_fg_disabled']->write(),
			'background-color' => 'transparent !important',
		)
	);
	
	
	$this->Decorator->rule(
		'#content > div.box', array(
			'position' => 'relative'
	));
	
	
	$this->Decorator->rule(
		'#header .menu.menu_1',
		array(
			'height' => $vg->size(array('g' => 1, 'u' => 2)),
		)
	);
	
	$this->Decorator->rule(
		'#header .menu.menu_2',
 		array(
 			'height' => $vg->size(array('g' => 1, 'u' => 2)),
			'position' => 'absolute',
			'top' => $vg->size('M3g'),
			'right' => $hg->size('g'),
			'z-index' => 100
		)
	);
	
	$this->Decorator->rule(
		'#header .menu.menu_2 a.selected, #header .menu.menu_2 a:hover',
		array(
			'height' => $vg->size(array('u' => '21')),
			'background-color' => $palette['text']->write(),
			'color' => $palette['bg']->write(),
		)
	);
	
	$this->Decorator->rule(
		'#header .menu.menu_2 a',
		array(
			'float' => 'left',
			'height' => $vg->size(array('g' => 1)),
			'background-color' => $palette['bg']->write(),
			'color' => $palette['text']->write(),
			'padding' => sprintf("%s %s %s %s !important", $u->t(0), $hg->size('m'), $u->t(0), $hg->size('m')),
			'margin-left' => $hg->size(array('g' => 0.5)),
			'border' => '0 !important',
 		)
 	);
	
	$this->Decorator->rule(
		'#header .menu.menu_1 a',
		array(
			'float' => 'left',
			'height' => $vg->size(array('g' => 1)),
			'background-color' => $palette['unselected_tab_bg']->write(),
			'color' => $palette['unselected_tab_text']->write(),
			'padding' => $vg->size(array('m' => 0.5)) . ' ' . $hg->size(array('g' => 0.5)) . ' 0 ' . $hg->size(array('g' => 0.5)),
			'margin-left' => $hg->size(array('g' => 0.5)),
			'border-bottom' => '0 !important'
		)
	);
	
	$this->Decorator->rule(
		'#header .menu.menu_1 a.selected',
		array(
			'height' => $vg->size(array('u' => '21')),
			'background-color' => $palette['bg']->write(),
			'color' => $palette['text']->write(),
			'font-weight' => 'bold',
			'margin-top' => $u->t(-6),
			'padding-top' => $vg->size(array('m' => 1)),
			'border' => $u->t(1) . ' solid ' . $palette['text']->write(),
			'border-bottom' => '0 !important'
		)
	);
	
	$this->Decorator->rule(
		'#header .menu a.menu_item_1_admin', array(
			'float' => 'right',
	));
	
	$this->Decorator->rule(
		'#header .menu a.menu_item_1_preferences', array(
			'float' => 'right',
			'margin-right' => $hg->size(array('g' => 0.5))
	));
	
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
		'a:hover, a:active',
		array(
			'color' => $palette['bg']->write(), 
			'background-color' => $palette['text']->write(),
			'border-color' => $palette['text']->write()
		)
	);

	$this->Decorator->rule(
		'a.disabled:hover', array(
			'color' => $palette['text'],
			'background-color' => 'transparent',
			'cursor' => 'default'
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
			'margin-bottom' => $vg->size(array('g' => 1.5)),
			'position' => 'relative',
			'z-index' => 10
	));
	
	$this->Decorator->rule(
		'h1', array(
			'font-size' => $u->t($line_height * 18/18),
			'line-height' => $u->t($line_height * 18/18),
			'font-weight' => 'normal'
	));
	
	$this->Decorator->rule(
		'.small_text', array(
			'font-size' => $u->t($line_height * 11/18)
	));

	$this->Decorator->rule(
		'.demoted', array(
			'color' => $palette['button_fg_disabled']
		)
	);
	
	
	// Control Box
	
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
		'.control_box .alternative_option', array(
			'margin' => $vg->size(array('m' => 6)) . ' 0 ' . $vg->size(array('m' => 2)) . ' ' . $vg->size(array('m' => 1)),
		)
	);

	$this->Decorator->rule(
		'.control_box button.submit.buro', array(
			'margin' => $vg->size(array('m' => 5)) . ' 0 ' . $vg->size(array('m' => 2)) . ' 0',
		)
	);
	
	$this->Decorator->rule(
		'.dashboard th a, .control_box a, table.backstage th a', array(
			'color' => $palette['control_box_fg']->write(),
			'border-color' =>  $palette['control_box_fg']->write()
		)
	);
	
	$this->Decorator->rule(
		'.dashboard th a:visited, .control_box a:visited, table.backstage th a:visited', array(
			'color' => $palette['control_box_fg']->write(),
			'border-color' =>  $palette['control_box_fg']->write()			
		)
	);
	
	$this->Decorator->rule(
		'.dashboard th a:hover, .dashboard th a:active, .control_box a:hover, .control_box a:active, table.backstage th a:hover, table.backstage th a:active', array(
			'color' => $palette['control_box_bg']->write() . ' !important',
			'background-color' => $palette['control_box_fg']->write() . ' !important',
			'border-color' =>  $palette['control_box_bg']->write() . ' !important'
		)
	);
	
	
	
	// Burocrata form
	
	$this->Decorator->rule(
		'.buro_form', array(
			'float' => 'left',
			'width' => '100%'
	));
	
	$this->Decorator->rule(
		'.buro_form div.input', array(
			'border-top' => $u->t(1) . ' solid ' . $palette['text'] ->write(),
			'padding-bottom' => $vg->size(array('g' => 2)),
			'position' => 'relative',
			'z-index' => 50
	));
	
	$this->Decorator->rule(
		'.buro_form div.input_relational', array(
			'position' => 'static',
	));
	
	$this->Decorator->rule(
		'.buro_form label.buro, .input.buro h4', array(
			'font-weight' => 'bold',
			'text-transform' => 'uppercase',
			'line-height' => $u->t($line_height * 4/3),
			'letter-spacing' => $letterSpacing,
			'display' => 'block'
	));
	
	$this->Decorator->rule(
		'#login_box label', array(
			'line-height' => $u->t($line_height),
			'display' => 'block'
	));
	
	$this->Decorator->rule(
		'.buro_form .instructions', array(
			'font-size' => $u->t($line_height * 11/18),
			'font-style' => 'italic',
			'display'	=> 'block'
	));

	
	
	
	// Pagination
	
	$this->Decorator->rule(
		'.pagination', array(
			'position' => 'absolute',
			'right' => 0,
			'top' => $vg->size(array('u' => 2+$line_height, 'm' => 2, 'g' => 1.5)), // total height of a .h1div
			'z-index' => 1
	));
	
	$padding_left = $hg->size(array('m' => 0.75), false);
	$this->Decorator->rule(
		'.pagination span', array(
			'display' => 'block',
			'float' => 'left',
			'text-align' => 'center',
			'margin-left' => $hg->size(array('m' => 0.75)),
			'min-width' => $hg->size(array('m' => 5)),
			'height' => $vg->size(array('g' => 1, 'm' => 0.6)),
			'border' => $hg->size(array('u' => 1)) . ' solid ' .  $palette['menu_border']->write(),
			'padding-top' => $vg->size(array('m' => 0.6)),
			'font-weight' => 'bold'
	));
	
	$this->Decorator->rule(
		'.pagination span.current, body div.pagination span:hover', array(
			'border-color' =>     $palette['internal_selection']->write(),
			'background-color' => $palette['internal_selection']->write(),
			'background-color' => $palette['internal_selection']->write(),
			'color' => $palette['bg']->write(),
			'cursor' => 'pointer'
	));
	
	$this->Decorator->rule(
		'body div.pagination span a', array(			
			'color' => $palette['text']->write(),
			'display' => 'block',
			'height' => $vg->size(array('g' => 1, 'm' => 1)),
			'margin-top' => $u->t(-2),
			'padding-top' => $vg->size(array('m' => 0.6)),
			
	));
	
	$this->Decorator->rule(
		'body div.pagination span a, body div.pagination span a:hover, body div.pagination span a:visited, body div.pagination span a:hover', array(
			'border' => 0, 'background' => 'transparent !important',
	));
	
	$this->Decorator->rule(
		'body div.pagination span a:hover, body div.pagination span a:visited', array(
			'color' => $palette['bg']->write() . ' !important',
	));
	
	$this->Decorator->rule(
		'div.pagination', array(
			'float' => 'right'
	));
	
	
	
	// LIST OF CONTENT TO CREATE
	
	$this->Decorator->rule(
		'#dash_additem', array(
			'position' => 'absolute',
			'z-index' => 5,
			'line-height' => $vg->size('6m'),
			'width' => $hg->size('12Mg'),
			'margin-left' => $hg->size('-g'),
			'background' => $palette['selection']->write(),
	));
	
	$this->Decorator->rule(
		'#dash_link_to_additem', array(
			'padding-top' => $hg->size('m-u'),
			'font-weight' => 700,
			'float' => 'left',
			'margin-bottom' => $hg->size('2m')
	));
	
	$this->Decorator->rule(
		'#dash_additem, #dash_link_to_additem', array(
			'display' => 'none'
	));
	
	$this->Decorator->rule(
		'#dash_additem.expanded, #dash_link_to_additem.expanded', array(
			'display' => 'block'
	));
	
	$this->Decorator->rule(
		'#dash_additem div.dash_itemlist', array(
			'float' => 'left',
			'margin-left' => $hg->size('g'),
			'max-width' => $hg->size('10M-g'),
	));
	
	$this->Decorator->rule(
		'#dash_link_to_additem.expanded a.disabled', array(
			'color' => $palette['button_fg_disabled']->write()
	));
	
	$this->Decorator->rule(
		'#dash_additem div.dash_itemlist a.disabled', array(
			'color' => $palette['button_fg_disabled']->write(),
			'cursor' => 'text'
	));
	
	$this->Decorator->rule(
		'#dash_additem div.dash_itemlist a.disabled:hover', array(
			'background-color' => 'transparent !important',
	));

	$this->Decorator->rule(
		'#dash_additem h3', array(
			'font-size' => $vg->size(array('u' => $line_height* 13/18)),
			'display' => 'inline',
			'margin-right' => $hg->size('m'),
			'text-transform' => 'uppercase',
			'letter-spacing' => $letterSpacing
	));
	
	
	
	$this->Decorator->rule(
		'#dash_additem > span', array(
			'float' => 'right',
			'margin-right' => $hg->size('g'),
			'max-width' => $hg->size('2M-g')
	));
	
	
	// SEARCH ON DASHBOARD
	
	$this->Decorator->rule(
		'div.dash_search', array(
			'width' => $hg->size('4M-g'),
			'float' => 'left',
			'margin-top' => $vg->size('-m-2u'),
			'height' => $vg->size('8m')
	));
	
	$this->Decorator->rule(
		'div.dash_search input', array(
			'margin-top' => $vg->size('-6m-2u')
	));
	
	$this->Decorator->rule(
		'div.dash_search input, div.dash_search label', array(
			'width' => $hg->size('4M-1.6g'),
			'border' => sprintf('%s solid %s', $u->t(1), $palette['input_borders']->write()),
			'height' => $vg->size('6m'),
			'line-height' => $vg->size('6m'),
			'padding' => sprintf('0 %s', $vg->size('m')),
			'font-style' => 'italic',
			'font-size' => $vg->size(array('u' => $line_height* 11/18)),
			'color'	=> $palette['input_fg']->write(),
			'display' => 'block'
	));
	
	$this->Decorator->rule(
		'div.dash_toolbox', array(
			'border-bottom' => $u->t(1) . ' solid black',
			'padding-bottom' => $vg->size(array('g' => 0.8)),
			'height' => $vg->size(array('m' => 4)),
	));
	
	$this->Decorator->rule(
		'.dash_filter, .dash_header', array(
			'margin-top' => $vg->size(array('m' => 3)),
			'margin-bottom' => $vg->size(array('m' => 2)),
			'font-size' => $vg->size(array('u' => $line_height* 11/18)),
	));
	
	$this->Decorator->rule(
		'#dash_filter_list .filters', array(
			'float' => 'left',
			'margin-right' => $hg->size(array('g' => 1))
	));
	
	
	$this->Decorator->rule(
		'#dash_filter_list a', array(
			'color' => $palette['text']->write(),
			'border-bottom' => 'none',
			'background-color' => $palette['bg']->write(),
			'margin-right' => $hg->size('m'),
			'padding' => '0 ' . $hg->size('m'),
			'display' => 'inline-block'
	));
	
	$this->Decorator->rule(
		'#dash_filter_list a.disabled', array(
			'color' => $palette['button_fg_disabled']->write(),
			'cursor' => 'text'
	));
	
	$this->Decorator->rule(
		'#dash_filter_list a.disabled:hover', array(
			'color' => $palette['button_fg_disabled']->write() . ' !important',
			'background' => 'none !important',
	));
	
	$this->Decorator->rule(
		'#dash_filter_list a:hover, #dash_filter_list a.selected', array(
			'color' => $palette['bg']->write() . ' !important',
			'background-color' => $palette['internal_selection']->write() . ' !important',
	));
	
	$this->Decorator->rule(
		'#dash_filter_list a.force_unselected:hover', array(
			'color' => $palette['text']->write() . ' !important',
			'background' => 'none !important',
	));
	
	$this->Decorator->rule(
		'.dash_filter h4', array(
			'font-size' => $vg->size(array('u' => $line_height* 11/18)),
			'display' => 'inline',
			'margin-right' => $hg->size(array('m' => 1)),
			'text-transform' => 'uppercase',
			'letter-spacing' => $letterSpacing,
			'float' => 'left'
	));
	
	$this->Decorator->rule(
		'.dash_filter .list_container', array(
			'float' => 'left',
			'width' => $hg->size('10M')
	));
	
	$border_size = 1;
	$padding_size = $hg->size(array('m' => 2), false);
	$margin_top = $vg->size(array('m' => 1), false);
	$margin_bottom = $vg->size(array('g' => 0.5),false) - $margin_top;
	$padding_top = $vg->size(array('m' => 1), false);
	$this->Decorator->rule(
		'.buro_form input[type=text], .buro_form input[type=password], .buro_form .textarea_container, form input[type=text], form input[type=password]', array(
			'border' => sprintf('%s solid %s', $u->t($border_size), $palette['input_borders']),
			'background-color' => $palette['input_bg'],
			'color'	=> $palette['input_fg'],
			'width' => $u->t($hg->size(array('M' => 5, 'g' => -1),false) - 2*($border_size + $padding_size)),
			'height' => $u->t($vg->size(array('g' => 1.5),false) - 2*$border_size - $padding_top),
			'padding' => $u->t($padding_top) . ' ' . $u->t($padding_size),
			'margin-top' => $u->t($margin_top),
			'margin-bottom' => $u->t($margin_bottom),
			'font-size' => $u->t($line_height * 13/18),
			'line-height' => $u->t($line_height)
	));
	
	$this->Decorator->rule(
		'.buro_form input[disabled]', array(
			'border-color' => $palette['bg'],
			'background-color' => $palette['read_only_bg'],
	));
	
	$this->Decorator->rule(
		'.buro_form input[type=text]:focus, .buro_form input[type=password]:focus, #login_box input[type=text]:focus, #login_box input[type=password]:focus, .buro_form .textarea_container.focus', array(
			'border-width' => $u->t($border_size+1),
			'margin' => implode(' ', array($u->t($margin_top-1), $u->t(-1), $u->t($margin_bottom-1), $u->t(-1)))
	));
	
	$this->Decorator->rule(
		'.buro_form .input_textile .textarea_container.focus', array(
			'margin' => implode(' ', array($u->t(8), $u->t(-1), $u->t($margin_bottom-1), $u->t(-1)))
	));
	
	$this->Decorator->rule(
		'#login_box input[type=text], #login_box input[type=password]', array(
			'width' => $u->t($hg->size(array('M' => 4, 'g' => -1),false) - 2*($border_size + $padding_size))
	));

	$this->Decorator->rule(
		'.input.buro .progress_bar', array(
			'border' => '1px solid ' . $palette['input_borders'],
			'height' => $u->t($vg->size(array('g' => 1.5),false) - 2*$border_size - $padding_top),
			'padding' => $u->t($padding_top) . ' ' . $u->t($padding_size),
			'width' => $u->t($hg->size(array('M' => 5, 'g' => -1),false) - 2*($border_size + $padding_size)),
			'position' => 'relative',
			'margin-top' => $vg->size('m')
		)
	);

	$this->Decorator->rule(
		'.input.buro .progress_bar .filling', array(
			'background' => $palette['menu_bg'],
			'float' => 'left',
			'height' => $u->t($vg->size(array('g' => 1.5),false) - 2*$border_size - $padding_top),
			'width' => 0
		)
	);

	$this->Decorator->rule(
		'.buro_form .buro_form .input.buro .progress_bar .filling', array(
			'background' => $palette['bg']
		)
	);

	$this->Decorator->rule(
		'.input.buro .progress_bar .label', array(
			'position' => 'absolute',
			'left' => 0,
			'text-align' => 'center',
			'width' => '100%'
		)
	);

	// Input upload

	$this->Decorator->rule(
		'.upload_control', array(
			'margin' => $vg->size('m') . ' 0'
		)
	);
	
	$this->Decorator->rule(
		'select.buro', array(
			'border' => $u->t($border_size) . ' solid ' .  $palette['input_borders'],
			'height' => $vg->size('1.5gm-2u'),
			'padding' => $u->t(3) . ' ' . $u->t(4),
	));
	
	$this->Decorator->rule(
		'.input_select select.buro, .input_relational select.buro.combo', array(
			'width' => $hg->size('5M-g'),
			'margin-top' => $vg->size('3u')
		)
	);
	
	$this->Decorator->rule(
		'.input_datetime select', array(
			'min-width' => $hg->size('M')
		)
	);
	
	$this->Decorator->rule(
		'select.buro.list', array(
			'height' => 'auto',
			'width' => $u->t($hg->size(array('M' => 5, 'g' => -1),false))
	));
	
	$this->Decorator->rule(
		'.input_checkbox label, .input_radio label, .input_multiple_checkbox .checkbox label, .input_relational .checkbox label', array(
			'line-height' => $u->t(4/3*$line_height)
	));
	
	$this->Decorator->rule(
		'.input_radio input.buro, .input_checkbox input.buro, .input_multiple_checkbox .checkbox input, .input_relational .checkbox input ', array(
			'height' => $u->t(4/3*$line_height),
			'margin-right' => $hg->size('m'),
			'vertical-align' => 'text-top'
	));
	
	
	$this->Decorator->rule(
		'.input_has_many select', array(
			'border' => $u->t($border_size) . ' solid ' .  $palette['input_borders']->write(),
			'padding-left' => $u->t($padding_size),
			'width' => $hg->size(array('M' => 5, 'g' => -1, 'u' => -$padding_size-2*$border_size)),
			'margin-right' => $hg->size(array('g' => 1)),
			'height' => 'auto'
	));
	
	$this->Decorator->rule(
		'.buro_form .superfield p', array(
			'font-size' => $u->t($line_height * 11/18),
	));
	
	$this->Decorator->rule(
		'.buro_form .superfield h6, .buro_form .input h6', array(
			'font-weight' => 'bold',
			'text-transform' => 'uppercase',
			'line-height' => $u->t($line_height * 4/3),
			'font-size' => $u->t($line_height * 13/18),
			'letter-spacing' => $letterSpacing,
			'display' => 'block'
	));
	
	$this->Decorator->rule(
		'.buro_form .superfield label.buro', array(
			'text-transform' => 'none',
			'font-size' => $u->t($line_height * 13/18),
			'line-height' => $u->t($line_height),
			'margin-top' => $hg->size(array('m' => 2)),
			'font-weight' => 'bold',
			'display'	=> 'block',
			'letter-spacing' => '0'
	));
	
	$this->Decorator->rule(
		'.superfield_container', array(
			'margin-top' => $u->t($line_height)
		)
	);
	
	
	$this->Decorator->rule(
		'.alternative_option', array(
			'margin' => $vg->size(array('m' => 1)) . ' 0 0 ' . $vg->size(array('m' => 1)),
			'float' => 'left'
	));
	
	$this->Decorator->rule(
		'button.submit.buro, #login_box input[type="submit"]', array(
			'-moz-border-radius'  => '5px',
			'border-radius' => '5px',
			'-webkit-border-radius' => '5px',
			'border' => '1px solid ' . $palette['text']->write(),
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
			'letter-spacing' => $letterSpacing
	));
	
	$this->Decorator->rule(
		'#login_box input[type="submit"]', array(
			'float' => 'right',
			'text-align' => 'center',
			'text-transform' => 'none',
			'width' => $vg->size(array('M' => 1, 'g' => -1)),
			'letter-spacing' => '0'
	));
	
	$this->Decorator->rule(
		'.error-message', array(
			'color' => $palette['error_message']->write(),
			'font-size' => $u->t($line_height * 11/18),
			'font-weight' => 'bold',
			'font-style' => 'italic'
	));
	
	$this->Decorator->rule(
		'.subinput input.form-error, .subinput textarea.form-error', array(
			'background-color' => $palette['input_error_bg']->write(),
			'color' => $palette['input_error_fg']->write(),
	));
	
	
	// Dinamic textarea
	
	$this->Decorator->rule(
		'.buro_form .textarea_container', array(
			'position' => 'relative',
			'min-height' => $u->t($line_height*5),
			'height' => 'auto',
			'padding' => '0',
			'width' => $u->t($hg->size(array('M' => 5, 'g' => -1),false) - 2*($border_size)),
	));
	
	$this->Decorator->rule(
		'.buro_form .textarea_container textarea', array(
			'position' => 'absolute',
			'top' => 0,
			'left' => 0,
			'overflow' => 'auto',
			'height' => '100%',
			'width' => '100%',
	));
	
	$this->Decorator->rule(
		'.buro_form .textarea_container pre, .textarea_container textarea', array(
			'padding' => $u->t($padding_top) . ' ' . $u->t($padding_size),
			'white-space' => 'pre-wrap',
			'word-wrap' => 'break-word',
			'resize' => 'none',
			'background' => 'transparent',
			'font-size' => $u->t($line_height * 13/18),
			'line-height' => $u->t($line_height),
			'-webkit-box-sizing' => 'border-box',
			   '-moz-box-sizing' => 'border-box',
			    '-ms-box-sizing' => 'border-box',
			        'box-sizing' => 'border-box',
	));
	
	
	$this->Decorator->rule(
		'.textarea_container pre', array(
			'visibility' => 'hidden',
			'display' => 'block',
			'padding-bottom' => $u->t($padding_top+$line_height) . ' !important',
			'max-height' => '450px'
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
	
	$this->Decorator->rule(
		'table.backstage', array(
			'border-spacing' => 0,
			'border-collapse' => 'collapse',
			'text-align' => 'left',
			'border-bottom' => $outer_border,
			'border-top' => $outer_border,
			'font-size' => $vg->size(array('u' => ($line_height * 11/18)))
	));
	
	$this->Decorator->rule(
		'table.admin_users', array(
			'border-spacing' => 0,
			'border-collapse' => 'collapse',
			'text-align' => 'left',
			'font-size' => $vg->size(array('u' => ($line_height * 11/18))),
			'margin-top' => $vg->size('g')
	));
	
	$this->Decorator->rule(
		'#dashboard_table', array(
			'clear' => 'both',
	));
	
	$this->Decorator->rule(
		'#backstage_custom_table', array(
			'clear' => 'both',
			'overflow' => 'auto'
	));
	
	//First IE specific:
	if ($browserInfo['name'] == 'Internet Explorer' && $browserInfo['version'] < 9)
	{
		$this->Decorator->rule(
			'table.dashboard, table.backstage', array(
				'table-layout' => 'fixed',
		));
	}
	
	$this->Decorator->rule(
		'table.dashboard th, table.backstage th', array(
			'background-color' => $palette['control_box_bg']->write(),
			'color' => $palette['control_box_fg']->write(),
			'height' => $vg->size(array('m' => 6))
	));
	
	$this->Decorator->rule(
		'table.admin_users th', array(
			'color' => $palette['text']->write(),
			'height' => $vg->size(array('m' => 6)),
			'font-size' => $vg->size(array('u' => ($line_height * 13/18)))
	));
	
	$this->Decorator->rule(
		'table.dashboard td, table.dashboard th, table.backstage td, table.backstage th', array(
			'padding-left' => $u->t($cell_padding_left),
			'padding-right' => $u->t($cell_padding_right),
			'padding-bottom' => $vg->size(array('m'=> 1.5)),
			'vertical-align' => 'text-top',
			'text-align' => 'left'
	));
	
	$this->Decorator->rule(
		'table.admin_users td, table.admin_users th', array(
			'padding-bottom' => $vg->size(array('m'=> 1.5)),
			'vertical-align' => 'text-top',
			'text-align' => 'left'
	));
	
	$this->Decorator->rule(
		'table.admin_users td div.actions', array(
			'margin-top' => $vg->size('m2u')
	));
	
	$this->Decorator->rule(
		'table.dashboard tr, table.backstage tr', array(
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
		'table.dashboard tr.actions.expanded, table.backstage tr.actions.expanded', array(
			'border-bottom' => $vg->size(array('u'=> 4)) . ' solid ' . $palette['internal_selection']->write()
	));
	
	$this->Decorator->rule(
		'table.dashboard tr.expanded, table.backstage tr.expanded', array(
			'border-left' => $hg->size(array('u'=> 4)) . ' solid ' . $palette['internal_selection']->write(),
			'border-right' => $hg->size(array('u'=> 4)) . ' solid ' . $palette['internal_selection']->write()
	));
	
	$this->Decorator->rule(
		'table.dashboard tr.main_info, table.dashboard tr.actions, table.backstage tr.main_info, table.backstage tr.actions, table.admin_users tr', array(
 			'border-bottom' => $u->t($border_width) . ' dashed ' . $palette['text']->write()
 	));
	
	$this->Decorator->rule(
		'table.dashboard td, table.backstage td', array(
			'padding-top' => $vg->size(array('m'=> 2))
	));
	
	$this->Decorator->rule(
		'table.dashboard th, table.backstage th', array(
			'padding-top' => $vg->size(array('m'=> 1.5)),
			'border-right' => $u->t($border_width) . ' solid ' . $palette['control_box_fg']->write()
	));
	
	$this->Decorator->rule(
		'table.dashboard th.last_col, table.backstage th.last_col', array(
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
		'table.dashboard a.link_button, table.backstage a.link_button', array(
			'font-size' => $u->t($line_height * 13/18),
			'padding-left' => $hg->size(array('m' => 1)),
			'padding-right' => $hg->size(array('m' => 1))
	));
	
	$this->Decorator->rule(
		'table.admin_users a.link_button', array(
			'font-size' => $u->t($line_height * 13/18),
			'padding-left' => $hg->size(array('m' => 1)),
			'padding-right' => $hg->size(array('m' => 1)),
			'height' => $vg->size('3m'),
			'line-height' => $vg->size('3m')
	));
	
	$this->Decorator->rule(
		'table.dashboard tr.actions td, table.dashboard tr.actions td *, table.backstage tr.actions td, table.backstage tr.actions td *', array(
			'vertical-align' => 'text-bottom'
	));
	
	$this->Decorator->rule(
		'table.dashboard tr.actions td, table.dashboard tr.actions div, table.backstage tr.actions td, table.backstage tr.actions div', array(
			'position' => 'relative',
			'height' => '100%',
			'bottom' => $hg->size(array('m' => 0.8))
	)); 
	
	$this->Decorator->rule(
		'table.dashboard th, table.backstage th', array(
			'font-weight' => 'bold',
			'text-transform' => 'uppercase',
			'letter-spacing' => $letterSpacing
	));
	
	$this->Decorator->rule(
		'.asc', array(
			'background' => "url('".Router::url('/img/matrixes/seta_baixo.png')."') right 0px no-repeat",
			'padding-right' => $u->t(16)
		
	));
	
	$this->Decorator->rule(
		'.asc:hover, .desc:hover', array(
			'background-position' => "right -10px",
	));
	
	$this->Decorator->rule(
		'.desc', array(
			'background' => "url('".Router::url('/img/matrixes/seta_cima.png')."') right 0px no-repeat",
			'padding-right' => $u->t(16)
		
	));
	
	$this->Decorator->rule(
		'.big_info_box', array(
			'background-color' => $palette['normal_popin']->write(),
			'margin-top' => $vg->size(array('g' => 1)),
			'margin-bottom' => $vg->size(array('g' => 1)),
			'padding-top' => $vg->size(array('m' => 2)),
			'padding-bottom' => $vg->size(array('m' => 2)),
		
	));
	
	$this->Decorator->rule(
		'.big_info_box .subtitle', array(
			'font-weight' => 'bold'
		
	));
	
	$this->Decorator->rule(
		'.big_info_box .info', array(
			'font-size' => $u->t(11),
			'margin-top' => $vg->size(array('g' => 1)),
		
	));
	
	$this->Decorator->rule(
		'span.draft', array(
			'color' => $palette['visited_links']->write()
	));
	
	
?>
.cpk-cont {position: absolute; z-index: 51; background-color: white; border: 1px solid black; padding: 10px; -moz-box-shadow:4px 4px 15px 1px #666; box-shadow:4px 4px 15px 1px #666;}
.cpk-color {width: 256px; height: 256px; position: absolute; top: 10px; left:10px; border: 1px solid black;}
.cpk-croma {width: 256px; height: 256px; background: url(../burocrata/img/cpk/croma.png); position: absolute; top:11px; left:11px; overflow: hidden;}
.cpk-h {height: 256px; width: 20px; background: url(../burocrata/img/cpk/hue.png); margin-left: 262px; border: 1px solid black; position: relative;}
.cpk-h > div {height: 1px;}
.cpk-hdrag {border:1px solid black; height:5px; width: 26px; margin-left: -3px; float: left;}
.cpk-picker {background: black; height: 3px; width: 3px; position: absolute;}
