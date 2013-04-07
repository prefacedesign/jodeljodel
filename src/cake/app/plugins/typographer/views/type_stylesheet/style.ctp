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

	echo $this->element($element, array('plugin' => 'typographer'));	

	$typeDecorator->compact = true;
	foreach($used_automatic_classes as $type => $params) //produz todas as regras autom�ticas
	{
		$styleFactory->{$type . 'GenerateClasses'}($params);
	}
	Configure::write('debug', 0);