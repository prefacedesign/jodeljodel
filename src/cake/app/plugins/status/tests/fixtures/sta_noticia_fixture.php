<?php 
class StaNoticiaFixture extends CakeTestFixture {
	var $name = 'StaNoticia';
	var $import = array('model'=>'StaNoticia', 'connection'=>'default', 'records'=>false);
	
	
	var $records = array(
		array ('id' => 1, 'status' => 'rascunho'),
		array ('id' => 2, 'status' => 'publicado'),
		array ('id' => 3, 'status' => 'rascunho'),
		array ('id' => 4, 'status' => 'rascunho'),
		array ('id' => 5, 'status' => 'publicado'),
		array ('id' => 6, 'status' => 'rascunho'),
		array ('id' => 7, 'status' => 'rascunho'),
		array ('id' => 8, 'status' => 'publicado'),
		array ('id' => 9, 'status' => 'rascunho'),
		array ('id' => 10, 'status' => 'publicado'),
		array ('id' => 12, 'status' => 'rascunho'),
		array ('id' => 15, 'status' => 'rascunho'),
		array ('id' => 16, 'status' => 'publicado'),
		array ('id' => 22, 'status' => 'publicado')
	);
	
	function create(&$db) {
		return true;
	}

	function drop(&$db) {
		return true;
	}
	
}
?> 