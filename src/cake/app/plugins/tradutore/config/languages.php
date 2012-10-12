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


Configure::write('Tradutore.mainLanguage', 'por');
Configure::write('Tradutore.languages', array('por', 'eng'));

Configure::write('Tradutore.guessingMethod', 'http'); // 'http', 'ip', false
Configure::write('Tradutore.guessingFallback', 'por'); // Some language to be used when was not possible to guess (false is acceptable)

?>
