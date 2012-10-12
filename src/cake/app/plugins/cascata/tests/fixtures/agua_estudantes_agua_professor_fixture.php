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

   class AguaEstudantesAguaProfessorFixture extends CakeTestFixture {
          var $name = 'AguaEstudantesAguaProfessor';
          var $import = array('table' => 'agua_estudantes_agua_professors');

          var $records = array(
              array (
                  'id' => 1,
                  'agua_estudante_id' => 1,
                  'agua_professor_id' => 1
                  ),
              array (
                  'id' => 2,
                  'agua_estudante_id' => 1,
                  'agua_professor_id' => 2
                  ),
              array (
                  'id' => 3,
                  'agua_estudante_id' => 2,
                  'agua_professor_id' => 1
                  ),
              array (
                  'id' => 4,
                  'agua_estudante_id' => 2,
                  'agua_professor_id' => 2
                  )
          );
   }


?>
