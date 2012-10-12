<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

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
	
	
	function testSetActiveStatuses()
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
	
	
	function testSetTwoActiveStatuses()
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
	
	
	
	function testFindAllWithCleanActiveStatuse()
	{
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$this->StaProduto->cleanActiveStatuses(array('disponibilidade','etapa'));
		$result = $this->StaProduto->find('all');
		$expected = array(
			'0' => array(
				'StaProduto' => array('id' => '1','status' => 'ativo','etapa' => 'verde')),
			'1' => array(
				'StaProduto' => array('id' => '2','status' => 'inativo','etapa' => 'maduro')),
			'2' => array(
				'StaProduto' => array('id' => '3','status' => 'ativo','etapa' => 'podre')),
			'3' => array(
				'StaProduto' => array('id' => '5','status' => 'ativo','etapa' => 'podre')),
			'4' => array(
				'StaProduto' => array('id' => '6','status' => 'ativo','etapa' => 'verde')),
			'5' => array(
				'StaProduto' => array('id' => '7','status' => 'ativo','etapa' => 'podre')),
			'6' => array(
				'StaProduto' => array('id' => '10','status' => 'inativo','etapa' => 'maduro')),
			'7' => array(
				'StaProduto' => array('id' => '12','status' => 'ativo','etapa' => 'verde')),
			'8' => array(
				'StaProduto' => array('id' => '13','status' => 'ativo','etapa' => 'maduro')),
			'9' => array(
				'StaProduto' => array('id' => '14','status' => 'inativo','etapa' => 'podre')),
			'10' => array(
				'StaProduto' => array('id' => '15','status' => 'ativo','etapa' => 'podre')),
			'11' => array(
				'StaProduto' => array('id' => '16','status' => 'ativo','etapa' => 'verde')),
			'12' => array(
				'StaProduto' => array('id' => '17','status' => 'ativo','etapa' => 'maduro')),
			'13' => array(
				'StaProduto' => array('id' => '22','status' => 'inativo','etapa' => 'podre')),
			'14' => array(
				'StaProduto' => array('id' => '30','status' => 'inativo','etapa' => 'verde'))
		);
		$this->assertEqual($result, $expected);
	}
	
	
	function testFindWithSetActiveStatusesPerformedBefore()
	{
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo'), 'etapa' => array('verde', 'maduro')));
		$result = $this->StaProduto->find('all');
		$expected = array(
			'0' => array(
				'StaProduto' => array('id' => '1','status' => 'ativo','etapa' => 'verde')),
			'1' => array(
				'StaProduto' => array('id' => '6','status' => 'ativo','etapa' => 'verde')),
			'2' => array(
				'StaProduto' => array('id' => '12','status' => 'ativo','etapa' => 'verde')),
			'3' => array(
				'StaProduto' => array('id' => '13','status' => 'ativo','etapa' => 'maduro')),
			'4' => array(
				'StaProduto' => array('id' => '16','status' => 'ativo','etapa' => 'verde')),
			'5' => array(
				'StaProduto' => array('id' => '17','status' => 'ativo','etapa' => 'maduro'))
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindWithMoreSetActiveStatusesPerformedBefore()
	{
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo'), 'etapa' => array('verde', 'maduro','podre')));
		$result = $this->StaProduto->find('all');
		$expected = array(
			'0' => array(
				'StaProduto' => array('id' => '1','status' => 'ativo','etapa' => 'verde')),
			'1' => array(
				'StaProduto' => array('id' => '3','status' => 'ativo','etapa' => 'podre')),
			'2' => array(
				'StaProduto' => array('id' => '5','status' => 'ativo','etapa' => 'podre')),
			'3' => array(
				'StaProduto' => array('id' => '6','status' => 'ativo','etapa' => 'verde')),
			'4' => array(
				'StaProduto' => array('id' => '7','status' => 'ativo','etapa' => 'podre')),
			'5' => array(
				'StaProduto' => array('id' => '12','status' => 'ativo','etapa' => 'verde')),
			'6' => array(
				'StaProduto' => array('id' => '13','status' => 'ativo','etapa' => 'maduro')),
			'7' => array(
				'StaProduto' => array('id' => '15','status' => 'ativo','etapa' => 'podre')),
			'8' => array(
				'StaProduto' => array('id' => '16','status' => 'ativo','etapa' => 'verde')),
			'9' => array(
				'StaProduto' => array('id' => '17','status' => 'ativo','etapa' => 'maduro'))
		);
		$this->assertEqual($result, $expected);
	}
	
	
	function testFindWithSetActiveStatusesAndOtherConditions()
	{
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$teste = $this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo','inativo'), 'etapa' => array('verde', 'maduro')));
		$result = $this->StaProduto->find('all', array('conditions' => array('StaProduto.status' => 'ativo')));
		$expected = array(
			'0' => array(
				'StaProduto' => array('id' => '1','status' => 'ativo','etapa' => 'verde')),
			'1' => array(
				'StaProduto' => array('id' => '6','status' => 'ativo','etapa' => 'verde')),
			'2' => array(
				'StaProduto' => array('id' => '12','status' => 'ativo','etapa' => 'verde')),
			'3' => array(
				'StaProduto' => array('id' => '13','status' => 'ativo','etapa' => 'maduro')),
			'4' => array(
				'StaProduto' => array('id' => '16','status' => 'ativo','etapa' => 'verde')),
			'5' => array(
				'StaProduto' => array('id' => '17','status' => 'ativo','etapa' => 'maduro'))
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindWithSetActiveStatusesAndAnotherConditions()
	{
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo','inativo'), 'etapa' => array('verde', 'maduro', 'podre')));
		$result = $this->StaProduto->find('all', array('conditions' => array('StaProduto.status' => 'ativo', 'StaProduto.etapa' => array('verde','podre'))));
		$expected = array(
			'0' => array(
				'StaProduto' => array('id' => '1','status' => 'ativo','etapa' => 'verde')),
			'1' => array(
				'StaProduto' => array('id' => '3','status' => 'ativo','etapa' => 'podre')),
			'2' => array(
				'StaProduto' => array('id' => '5','status' => 'ativo','etapa' => 'podre')),
			'3' => array(
				'StaProduto' => array('id' => '6','status' => 'ativo','etapa' => 'verde')),
			'4' => array(
				'StaProduto' => array('id' => '7','status' => 'ativo','etapa' => 'podre')),
			'5' => array(
				'StaProduto' => array('id' => '12','status' => 'ativo','etapa' => 'verde')),
			'6' => array(
				'StaProduto' => array('id' => '15','status' => 'ativo','etapa' => 'podre')),
			'7' => array(
				'StaProduto' => array('id' => '16','status' => 'ativo','etapa' => 'verde')),
		);
		$this->assertEqual($result, $expected);
	}
	
	
	function testFindAllWithConditionsInline()
	{
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$teste = $this->StaProduto->setActiveStatuses(array('disponibilidade' => array('ativo'), 'etapa' => array('verde', 'maduro', 'podre')));
		$result = $this->StaProduto->find('all', array('conditions' => 'StaProduto.id in (1,2,3,4,5) AND StaProduto.etapa = "verde"'));
		$expected = array(
			'0' => array(
				'StaProduto' => array('id' => '1','status' => 'ativo','etapa' => 'verde'))
		);
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
		$result = $this->StaProduto->find('all');
		$expected = array(
			'0' => array(
				'StaProduto' => array('id' => '1','status' => 'ativo','etapa' => 'verde')),
			'1' => array(
				'StaProduto' => array('id' => '6','status' => 'ativo','etapa' => 'verde')),
			'2' => array(
				'StaProduto' => array('id' => '12','status' => 'ativo','etapa' => 'verde')),
			'3' => array(
				'StaProduto' => array('id' => '16','status' => 'ativo','etapa' => 'verde'))
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
				'StaProduto' => array('id' => '1','status' => 'ativo','etapa' => 'verde')),
			'1' => array(
				'StaProduto' => array('id' => '2','status' => 'inativo','etapa' => 'maduro')),
			'2' => array(
				'StaProduto' => array('id' => '6','status' => 'ativo','etapa' => 'verde')),
			'3' => array(
				'StaProduto' => array('id' => '10','status' => 'inativo','etapa' => 'maduro')),
			'4' => array(
				'StaProduto' => array('id' => '12','status' => 'ativo','etapa' => 'verde')),
			'5' => array(
				'StaProduto' => array('id' => '13','status' => 'ativo','etapa' => 'maduro')),
			'6' => array(
				'StaProduto' => array('id' => '16','status' => 'ativo','etapa' => 'verde')),
			'7' => array(
				'StaProduto' => array('id' => '17','status' => 'ativo','etapa' => 'maduro')),
			'8' => array(
				'StaProduto' => array('id' => '30','status' => 'inativo','etapa' => 'verde'))
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
				'StaProduto' => array('id' => '1','status' => 'ativo','etapa' => 'verde')),
			'1' => array(
				'StaProduto' => array('id' => '2','status' => 'inativo','etapa' => 'maduro')),
			'2' => array(
				'StaProduto' => array('id' => '6','status' => 'ativo','etapa' => 'verde')),
			'3' => array(
				'StaProduto' => array('id' => '10','status' => 'inativo','etapa' => 'maduro')),
			'4' => array(
				'StaProduto' => array('id' => '12','status' => 'ativo','etapa' => 'verde')),
			'5' => array(
				'StaProduto' => array('id' => '13','status' => 'ativo','etapa' => 'maduro')),
			'6' => array(
				'StaProduto' => array('id' => '16','status' => 'ativo','etapa' => 'verde')),
			'7' => array(
				'StaProduto' => array('id' => '17','status' => 'ativo','etapa' => 'maduro')),
			'8' => array(
				'StaProduto' => array('id' => '30','status' => 'inativo','etapa' => 'verde'))
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindAfterSetGlobalActiveStatusWithoutOverwriteButThatShouldBeConsideredCauseThereAreNotAnotherStatusSettled()
	{	
		StatusBehavior::setGlobalActiveStatuses(array(
			'disponibilidade' => array(
				'active' => array('ativo','inativo'), 
				'overwrite' => false
			), 
			'etapa' => array(
				'active' => array('verde'), 
				'overwrite' => false
			)
		));
		$this->StaProduto =& ClassRegistry::init('StaProduto');
		$this->StaProduto->cleanActiveStatuses(array('disponibilidade','etapa'));
		$result = $this->StaProduto->find('all');
		$expected = array(
			'0' => array(
				'StaProduto' => array('id' => '1','status' => 'ativo','etapa' => 'verde')),
			'1' => array(
				'StaProduto' => array('id' => '6','status' => 'ativo','etapa' => 'verde')),
			'2' => array(
				'StaProduto' => array('id' => '12','status' => 'ativo','etapa' => 'verde')),
			'3' => array(
				'StaProduto' => array('id' => '16','status' => 'ativo','etapa' => 'verde')),
			'4' => array(
				'StaProduto' => array('id' => '30','status' => 'inativo','etapa' => 'verde'))
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