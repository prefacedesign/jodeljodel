<?php 
// to work easily. in the model just use: var $actsAs = array('Stastatus.StaStatus');
Configure::write('StatusBehavior.options.default', array('field' => 'status', 'options' => array('rascunho','publicado'), 'active' => array('publicado')));

class StaNoticiaFixture extends CakeTestFixture {
	var $name = 'StaNoticia';
	var $import = array('model'=>'StaNoticia', 'connection'=>'default', 'records'=>false);
	
	
	var $records = array(
		array ('id' => 1, 'status' => 'rascunho'),
		array ('id' => 2, 'status' => 'publicado'),
		array ('id' => 3, 'status' => 'rascunho')
	);
	
	function create(&$db) {
		return true;
	}

	function drop(&$db) {
		return true;
	}
	
}
?> 