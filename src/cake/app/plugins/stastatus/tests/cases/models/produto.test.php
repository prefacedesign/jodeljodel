<?php 
App::import('Model','Stastatus.Produto');

class ProdutoTestCase extends CakeTestCase {
    var $fixtures = array('plugin.stastatus.produto');
	
	
	function testChangeStatus() 
	{
        $this->Produto =& ClassRegistry::init('Produto');
        $result = $this->Produto->changeStatus(1, array('disponibilidade' => 'ativo', 'etapa' => 'maduro'), false);
        $expected = true;
        $this->assertEqual($result, $expected);
    } 
	
	
	function testSetStatusesActive()
	{
		$this->Produto =& ClassRegistry::init('Produto');
		$result = $this->Produto->setStatusesActive(array('disponibilidade' => array('ativo')));
		$expected = array(
			'Produto' => array(
				'disponibilidade' => array(
					'field' => 'status',
					'options' => array('ativo', 'inativo'),
					'active' => array('ativo')
				),
				'etapa' => array(
					'field' => 'etapa',
					'options' => array('verde','maduro','podre'),
					'active' => array('verde','maduro','podre')
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testSetTwoStatusesActive()
	{
		$this->Produto =& ClassRegistry::init('Produto');
		$result = $this->Produto->setStatusesActive(array('disponibilidade' => array('ativo'), 'etapa' => array('verde', 'maduro')));
		$expected = array(
			'Produto' => array(
				'disponibilidade' => array(
					'field' => 'status',
					'options' => array('ativo', 'inativo'),
					'active' => array('ativo')
				),
				'etapa' => array(
					'field' => 'etapa',
					'options' => array('verde','maduro','podre'),
					'active' => array('verde', 'maduro')
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindAll()
	{
		$this->Produto =& ClassRegistry::init('Produto');
		$this->Produto->setStatusesActive(array('disponibilidade' => array('ativo','inativo'), 'etapa' => array('verde', 'maduro', 'podre')));
		$result = $this->Produto->find('all');
		$expected = array(
			'0' => array(
				'Produto' => array(
					'id' => '1',
					'status' => 'ativo',
					'etapa' => 'verde'
				)
			),
			'1' => array(
				'Produto' => array(
					'id' => '2',
					'status' => 'inativo',
					'etapa' => 'maduro'
				)
			),
			'2' => array(
				'Produto' => array(
					'id' => '3',
					'status' => 'ativo',
					'etapa' => 'podre'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindWithSetStatuses()
	{
		$this->Produto =& ClassRegistry::init('Produto');
		$this->Produto->setStatusesActive(array('disponibilidade' => array('ativo'), 'etapa' => array('verde', 'maduro')));
		$result = $this->Produto->find('all');
		$expected = array(
			'0' => array(
				'Produto' => array(
					'id' => '1',
					'status' => 'ativo',
					'etapa' => 'verde'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindWithMoreStatuses()
	{
		$this->Produto =& ClassRegistry::init('Produto');
		$this->Produto->setStatusesActive(array('disponibilidade' => array('ativo'), 'etapa' => array('verde', 'maduro','podre')));
		$result = $this->Produto->find('all');
		$expected = array(
			'0' => array(
				'Produto' => array(
					'id' => '1',
					'status' => 'ativo',
					'etapa' => 'verde'
				)
			),
			'1' => array(
				'Produto' => array(
					'id' => '3',
					'status' => 'ativo',
					'etapa' => 'podre'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	
	function testFindWithSetStatusesaAndOtherConditions()
	{
		$this->Produto =& ClassRegistry::init('Produto');
		$teste = $this->Produto->setStatusesActive(array('disponibilidade' => array('ativo','inativo'), 'etapa' => array('verde', 'maduro')));
		$result = $this->Produto->find('all', array('conditions' => array('Produto.status' => 'ativo')));
		$expected = array(
			'0' => array(
				'Produto' => array(
					'id' => '1',
					'status' => 'ativo',
					'etapa' => 'verde'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindWithSetStatusesaAndAnotherConditions()
	{
		$this->Produto =& ClassRegistry::init('Produto');
		$this->Produto->setStatusesActive(array('disponibilidade' => array('ativo','inativo'), 'etapa' => array('verde', 'maduro', 'podre')));
		$result = $this->Produto->find('all', array('conditions' => array('Produto.status' => 'ativo', 'Produto.etapa' => array('verde','podre'))));
		$expected = array(
			'0' => array(
				'Produto' => array(
					'id' => '1',
					'status' => 'ativo',
					'etapa' => 'verde'
				)
			),
			'1' => array(
				'Produto' => array(
					'id' => '3',
					'status' => 'ativo',
					'etapa' => 'podre'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	
	function testFindWithConditionsInline()
	{
		$this->Produto =& ClassRegistry::init('Produto');
		$teste = $this->Produto->setStatusesActive(array('disponibilidade' => array('ativo'), 'etapa' => array('verde', 'maduro', 'podre')));
		$result = $this->Produto->find('all', array('conditions' => 'Produto.id = 2 AND Produto.etapa = "verde"'));
		$expected = array();
		$this->assertEqual($result, $expected);
	}
	
}
?> 