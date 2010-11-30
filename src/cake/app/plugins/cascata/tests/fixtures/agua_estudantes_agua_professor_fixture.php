<?php
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
