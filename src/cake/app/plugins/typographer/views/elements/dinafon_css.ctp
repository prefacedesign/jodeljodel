<?php

$this->Decorator->rule(
	'*', array(
		'margin' => '0',
		'padding' => '0',
		'list-style' => 'none',
		'text-decoration' => 'none',
		'font-family' => '"Lucida Sans", "Bitstream Vera", sans',
		'font-size' => $u->t($standardFontSize),
		'line-height' => $u->t($lineHeight),
		'border' => '0'
));


// BOXES 
$this->Decorator->rule(
	'.box', array(
		'margin-left' => $hg->size('g'),
		'margin-bottom' => $u->t($lineHeight),
		'float' => 'left'
));

$this->Decorator->rule(
	'.box_container', array(
		'float' => 'left'
));

// PIE FILE
$this->Decorator->rule(
	'.pie_file img', array(
		'margin-top' => '-2px',
		'vertical-align' => 'text-bottom'
));
