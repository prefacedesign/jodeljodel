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

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*
insert into agua_escolas (nome) values ('escolinha');
insert into agua_escolas (nome) values ('escolona');
 */
   class AguaEscolaFixture extends CakeTestFixture {
          var $name = 'AguaEscola';
          var $import = 'Cascata.AguaEscola';

          var $records = array(
              array (
                  'id' => 1,
                  'nome' => 'escolinha'
                  ),
              array (
                  'id' => 2,
                  'nome' => 'escolona'
                  )
          );
   }
?>

