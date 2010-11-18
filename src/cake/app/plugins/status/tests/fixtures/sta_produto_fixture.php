<?php 
class StaProdutoFixture extends CakeTestFixture {
	var $name = 'StaProduto';
	var $import = array('model'=>'StaProduto', 'connection'=>'default', 'records'=>false);
	
	
	var $records = array(
		array ('id' => 1, 'status' => 'ativo', 'etapa' => 'verde'),
		array ('id' => 2, 'status' => 'inativo', 'etapa' => 'maduro'),
		array ('id' => 3, 'status' => 'ativo', 'etapa' => 'podre'),
		array ('id' => 5, 'status' => 'ativo', 'etapa' => 'podre'),
		array ('id' => 6, 'status' => 'ativo', 'etapa' => 'verde'),
		array ('id' => 7, 'status' => 'ativo', 'etapa' => 'podre'),
		array ('id' => 10, 'status' => 'inativo', 'etapa' => 'maduro'),
		array ('id' => 12, 'status' => 'ativo', 'etapa' => 'verde'),
		array ('id' => 13, 'status' => 'ativo', 'etapa' => 'maduro'),
		array ('id' => 14, 'status' => 'inativo', 'etapa' => 'podre'),
		array ('id' => 15, 'status' => 'ativo', 'etapa' => 'podre'),
		array ('id' => 16, 'status' => 'ativo', 'etapa' => 'verde'),
		array ('id' => 17, 'status' => 'ativo', 'etapa' => 'maduro'),
		array ('id' => 22, 'status' => 'inativo', 'etapa' => 'podre'),
		array ('id' => 30, 'status' => 'inativo', 'etapa' => 'verde')
	);
	
	function create(&$db) {
		return true;
	}

	function drop(&$db) {
		return true;
	}
	
}
?> 