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

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

   class AguaAsAguaCFixture extends CakeTestFixture {
          var $name = 'AguaAsAguaC';
          var $import = array('table' => 'agua_as_agua_cs');

          var $records = array(
              array (
                  'id' => 1,
                  'agua_a_id' => 1,
                  'agua_c_id' => 1
                  ),
          );
   }


?>
