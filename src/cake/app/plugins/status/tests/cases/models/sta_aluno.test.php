<?php 
App::import('Model','Status.StaAluno');
App::import('Model','Status.StaCategoria');

class StaAlunoTestCase extends CakeTestCase {
    var $fixtures = array('plugin.status.sta_aluno');
		
	function testFindAll()
	{
		$this->StaAluno =& ClassRegistry::init('StaAluno');
		$this->StaCategoria =& ClassRegistry::init('StaCategoria');
		$result = $this->StaCategoria->setActiveStatuses(array('status' => array('ativo')));
		debug($result);
		//$result = $this->StaCategoria->find('all');
		//debug($result);
		$result = $this->StaAluno->find('all');
		debug($result);
		$expected = array(
			'0' => array(
				'StaAluno' => array('id' => '1','nome' => 'Paulo', 'categoria_id' => '1'),
				'Categoria' => array('id' => '1', 'nome' => 'Bom', 'status' => 'ativo')),
			'1' => array(
				'StaAluno' => array('id' => '2','nome' => 'Joao', 'categoria_id' => '1'),
				'Categoria' => array('id' => '1', 'nome' => 'Bom', 'status' => 'ativo')),
			'2' => array(
				'StaAluno' => array('id' => '3','nome' => 'Marco', 'categoria_id' => '2'),
				'Categoria' => array('id' => '2', 'nome' => 'Razoável', 'status' => 'inativo')),
			'3' => array(
				'StaAluno' => array('id' => '4','nome' => 'Joana', 'categoria_id' => '1'),
				'Categoria' => array('id' => '1', 'nome' => 'Bom', 'status' => 'ativo')),
			'4' => array(
				'StaAluno' => array('id' => '5','nome' => 'Rogeria', 'categoria_id' => '1'),
				'Categoria' => array('id' => '1', 'nome' => 'Bom', 'status' => 'ativo')),
			'5' => array(
				'StaAluno' => array('id' => '6','nome' => 'Maria', 'categoria_id' => '2'),
				'Categoria' => array('id' => '2', 'nome' => 'Razoável', 'status' => 'inativo'))
		);
		//debug($expected);
		$this->assertEqual($result, $expected);
	}
}