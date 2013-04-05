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
/*
insert into agua_professors (nome,agua_escola_id,agua_equipe_id) values ('joão',1,1);
insert into agua_professors (nome,agua_escola_id,agua_equipe_id) values ('josé',2,2);
 */
   class AguaProfessorFixture extends CakeTestFixture {
          var $name = 'AguaProfessor';
          var $import = 'Cascata.AguaProfessor';

          var $records = array(
              array (
                  'id' => 1,
                  'nome' => 'joão',
                  'agua_escola_id' => 1,
                  'agua_equipe_id' => 1
                  ),
              array (
                  'id' => 2,
                  'nome' => 'josé',
                  'agua_escola_id' => 2,
                  'agua_equipe_id' => 2
                  )
          );
   }
?>

