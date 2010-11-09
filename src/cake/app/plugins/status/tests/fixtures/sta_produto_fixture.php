<?php 
// to test with default configuration of the behavior
Configure::write('StatusBehavior.options.disponibilidade', array('field' => 'status', 'options' => array('ativo','inativo')));
Configure::write('StatusBehavior.options.etapa', array('options' => array('verde','maduro','podre')));


class StaProdutoFixture extends CakeTestFixture {
	var $name = 'StaProduto';
	var $import = array('model'=>'StaProduto', 'connection'=>'default', 'records'=>false);
	
	
	var $records = array(
		array ('id' => 1, 'status' => 'ativo', 'etapa' => 'verde'),
		array ('id' => 2, 'status' => 'inativo', 'etapa' => 'maduro'),
		array ('id' => 3, 'status' => 'ativo', 'etapa' => 'podre')
	);
	
	function create(&$db) {
		return true;
	}

	function drop(&$db) {
		return true;
	}
	
}
?> 