<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CorkCorktileFixture extends CakeTestFixture {
	  var $name = 'CorkCorktile';
	  var $import = 'Corktile.CorkCorktile';

	  var $records = array(
		  array (
			  'key' => 'texto_teste',
			  'type' => 'text',
			  'localization' => 'aqui ó',
			  'description' => 'Esse é um texto de teste sacou?',
			  'id_content' => 1
			  ),
	  );
}


?>
