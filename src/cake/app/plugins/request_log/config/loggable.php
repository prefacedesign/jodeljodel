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
 
Configure::write('RequestLog.loggable', false);

// 'admin'  - logs all admin actions
// 'public' - logs all public actions
// 'css' 	- logs all css actions (typographer get requests)
// 'media'  - logs all media actions (media get requests)
Configure::write('RequestLog.what_to_log', array('admin', 'public', 'css', 'media')); 


?>
