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
   class AguaBFixture extends CakeTestFixture {
          var $name = 'AguaB';
          var $import = 'Cascata.AguaB';

          var $records = array(
              array (
                  'id' => 1,
                  'nome' => 'nome',
                  'agua_a_id' => 1
                  ),
          );
   }

?>
