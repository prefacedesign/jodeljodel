<?php
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

