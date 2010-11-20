<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

   class AguaJFixture extends CakeTestFixture {
          var $name = 'AguaJ';
          var $import = 'Cascata.AguaJ';

        var $fields = array(
            'id' => array('type' => 'integer', 'key' => 'primary'),
            'title' => array('type' => 'string', 'null' => false)
        );


          var $records = array(
              array ('id' => 1, 'title' => 'J1', ),
              array ('id' => 2, 'title' => 'J2', ),
          );
   }


?>
