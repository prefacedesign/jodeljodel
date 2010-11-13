<?php 
App::import('Model','Status.StaProduto');

class StaProdutoTestCase extends CakeTestCase {
    var $fixtures = array('plugin.status.sta_produto');
	
	
	function testSetStatus() 
	{
        $this->StaProduto =& ClassRegistry::init('StaProduto');
        $result = $this->StaProduto->setStatus(1, array('disponibilidade' => 'ativo', 'etapa' => 'maduro'), false);
        $expected = true;
        $this->assertEqual($result, $expected);
    } 
	
	
	function testsetActiveStatuses()
	{
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$result = $this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo')));
		$expected = array(
			'StaProduto' => array(
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
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$result = $this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo'), 'etapa' => array('verde', 'maduro')));
		$expected = array(
			'StaProduto' => array(
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
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo','inativo'), 'etapa' => array('verde', 'maduro', 'podre')));
		$result = $this->StaProduto->find('all');
		$expected = array(
			'0' => array(
				'StaProduto' => array(
					'id' => '1',
					'status' => 'ativo',
					'etapa' => 'verde'
				)
			),
			'1' => array(
				'StaProduto' => array(
					'id' => '2',
					'status' => 'inativo',
					'etapa' => 'maduro'
				)
			),
			'2' => array(
				'StaProduto' => array(
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
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo'), 'etapa' => array('verde', 'maduro')));
		$result = $this->StaProduto->find('all');
		$expected = array(
			'0' => array(
				'StaProduto' => array(
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
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo'), 'etapa' => array('verde', 'maduro','podre')));
		$result = $this->StaProduto->find('all');
		$expected = array(
			'0' => array(
				'StaProduto' => array(
					'id' => '1',
					'status' => 'ativo',
					'etapa' => 'verde'
				)
			),
			'1' => array(
				'StaProduto' => array(
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
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$teste = $this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo','inativo'), 'etapa' => array('verde', 'maduro')));
		$result = $this->StaProduto->find('all', array('conditions' => array('StaProduto.status' => 'ativo')));
		$expected = array(
			'0' => array(
				'StaProduto' => array(
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
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo','inativo'), 'etapa' => array('verde', 'maduro', 'podre')));
		$result = $this->StaProduto->find('all', array('conditions' => array('StaProduto.status' => 'ativo', 'StaProduto.etapa' => array('verde','podre'))));
		$expected = array(
			'0' => array(
				'StaProduto' => array(
					'id' => '1',
					'status' => 'ativo',
					'etapa' => 'verde'
				)
			),
			'1' => array(
				'StaProduto' => array(
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
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$teste = $this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo'), 'etapa' => array('verde', 'maduro', 'podre')));
		$result = $this->StaProduto->find('all', array('conditions' => 'StaProduto.id = 2 AND StaProduto.etapa = "verde"'));
		$expected = array();
		$this->assertEqual($result, $expected);
	}
	
	
	function testSetGlobalActiveStatuses()
	{
		$result = StatusBehavior::setGlobalActiveStatuses(array('etapa' => array('active' => array('verde'), 'overwrite' => true)));
		$expected = array(
			'disponibilidade' => array(
				'field' => 'status',
				'options' => array(
					'0' => 'ativo',
					'1' => 'inativo'
				)
			),
			'etapa' => array(
				'options' => array(
					'0' => 'verde',
					'1' => 'maduro',
					'2' => 'podre'
				),
				'active' => array(
					'0' => 'verde'
				),
				'overwrite' => true
			),
			'default' => array(
				'field' => 'status',
				'options' => array(
                    '0' => 'rascunho',
                    '1' => 'publicado'
                ),
				'active' => array(
                    '0' => 'publicado'
                )
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testTwoSetGlobalActiveStatuses()
	{
		$result = StatusBehavior::setGlobalActiveStatuses(array(
			'etapa' => array(
				'active' => array('verde','maduro'), 
				'overwrite' => true
			),
			'disponibilidade' => array(
				'active' => array('ativo'),
				'overwrite' => false
				
			)
		));
		$expected = array(
			'disponibilidade' => array(
				'field' => 'status',
				'options' => array(
					'0' => 'ativo',
					'1' => 'inativo'
				),
				'active' => array(
					'0' => 'ativo'
				),
				'overwrite' => false
			),
			'etapa' => array(
				'options' => array(
					'0' => 'verde',
					'1' => 'maduro',
					'2' => 'podre'
				),
				'active' => array(
					'0' => 'verde',
					'1' => 'maduro'
				),
				'overwrite' => true
			),
			'default' => array(
				'field' => 'status',
				'options' => array(
                    '0' => 'rascunho',
                    '1' => 'publicado'
                ),
				'active' => array(
                    '0' => 'publicado'
                )
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindAfterSetGlobalActiveStatus()
	{	
		StatusBehavior::setGlobalActiveStatuses(array('etapa' => array('active' => array('verde'), 'overwrite' => true)));
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		//$teste = $this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo'), 'etapa' => array('verde', 'maduro', 'podre')));
		$result = $this->StaProduto->find('all');
		//debug($result);
		$expected = array(
			'0' => array(
				'StaProduto' => array(
					'id' => '1',
					'status' => 'ativo',
					'etapa' => 'verde'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindAfterSetGlobalActiveStatusButWithActiveStatusSettledInline()
	{	
		StatusBehavior::setGlobalActiveStatuses(array('etapa' => array('active' => array('verde'), 'overwrite' => true)));
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		//$teste = $this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo'), 'etapa' => array('verde', 'maduro', 'podre')));
		$result = $this->StaProduto->find('all',array('active_statuses' => array('etapa' => array('verde', 'maduro'), 'disponibilidade' => array('ativo', 'inativo'))));
		//debug($result);
		$expected = array(
			'0' => array(
				'StaProduto' => array(
					'id' => '1',
					'status' => 'ativo',
					'etapa' => 'verde'
				)
			),
			'1' => array(
				'StaProduto' => array(
					'id' => '2',
					'status' => 'inativo',
					'etapa' => 'maduro'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	
	function testFindAfterSetGlobalActiveStatusWithoutOverwrite()
	{	
		StatusBehavior::setGlobalActiveStatuses(array('etapa' => array('active' => array('verde'), 'overwrite' => false)));
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo', 'inativo'), 'etapa' => array('verde', 'maduro')));
		$result = $this->StaProduto->find('all');
		//debug($result);
		$expected = array(
			'0' => array(
				'StaProduto' => array(
					'id' => '1',
					'status' => 'ativo',
					'etapa' => 'verde'
				)
			),
			'1' => array(
				'StaProduto' => array(
					'id' => '2',
					'status' => 'inativo',
					'etapa' => 'maduro'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindAfterSetGlobalActiveStatusWithoutOverwriteButThatShouldBeConsideredCauseThereAreNotAnotherStatusSettled()
	{	
		StatusBehavior::setGlobalActiveStatuses(array('etapa' => array('active' => array('verde'), 'overwrite' => false)));
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$this->StaProduto->cleanActiveStatuses(array('disponibilidade','etapa'));
		$result = $this->StaProduto->find('all');
		$expected = array(
			'0' => array(
				'StaProduto' => array(
					'id' => '1',
					'status' => 'ativo',
					'etapa' => 'verde'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	
	
	function testFindAfterSetGlobalActiveStatusWithDifferentStatusSetGlobalAndLocal()
	{	
		StatusBehavior::setGlobalActiveStatuses(array('etapa' => array('active' => array('verde','maduro'), 'overwrite' => false)));
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$result = $this->StaProduto->setActiveStatuses(array('etapa' => array('verde')));
		if (!$result)
			$this->assertEqual(true, false);
		else
			$this->assertEqual(true, true);
	}
	
	
}
?> 