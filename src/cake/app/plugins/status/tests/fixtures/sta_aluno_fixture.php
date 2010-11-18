<?php 
class StaAlunoFixture extends CakeTestFixture {
	var $name = 'StaAluno';
	var $import = array('model'=>'StaAluno', 'connection'=>'default', 'records'=>false);
	
	
	var $records = array(
		array ('id' => 1, 'nome' => 'Paulo', 'categoria_id' => 1),
		array ('id' => 2, 'nome' => 'Joao', 'categoria_id' => 1),
		array ('id' => 3, 'nome' => 'Marco', 'categoria_id' => 2),
		array ('id' => 4, 'nome' => 'Joana', 'categoria_id' => 1),
		array ('id' => 5, 'nome' => 'Rogeria', 'categoria_id' => 1),
		array ('id' => 6, 'nome' => 'Maria', 'categoria_id' => 2)
	);
	
	function create(&$db) {
		return true;
	}

	function drop(&$db) {
		return true;
	}
	
}
?> 