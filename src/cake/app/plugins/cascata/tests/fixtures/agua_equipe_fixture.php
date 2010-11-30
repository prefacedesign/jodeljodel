<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 * insert into agua_equipes (nome) values ('a grande');
insert into agua_equipes (nome) values ('a pequena');
 */
   class AguaEquipeFixture extends CakeTestFixture {
          var $name = 'AguaEquipe';
          var $import = 'Cascata.AguaEquipe';

          var $records = array( 
              array (
                  'id' => 1,
                  'nome' => 'a grande'
                  ),
              array (
                  'id' => 2,
                  'nome' => 'a pequena'
                  )
          );
   }
?>

