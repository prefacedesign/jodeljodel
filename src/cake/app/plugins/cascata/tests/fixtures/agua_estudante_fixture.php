<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*
insert into agua_escolas (nome) values ('escolinha');
insert into agua_escolas (nome) values ('escolona');
 */
   class AguaEstudanteFixture extends CakeTestFixture {
          var $name = 'AguaEstudante';
          var $import = 'Cascata.AguaEstudante';

          var $records = array(
              array (
                  'id' => 1,
                  'nome' => 'maria'
                  ),
              array (
                  'id' => 2,
                  'nome' => 'paula'
                  )
          );
   }
?>
