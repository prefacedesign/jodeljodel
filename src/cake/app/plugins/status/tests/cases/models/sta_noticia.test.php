<?php 
App::import('Model','Status.StaNoticia');

class StaNoticiaTestCase extends CakeTestCase {
    var $fixtures = array('plugin.status.sta_noticia');
	
	function testChangeStatus() 
	{
        $this->StaNoticia =& ClassRegistry::init('StaNoticia');
        $result = $this->StaNoticia->changeStatus(1, array('status' => 'publicado'));
        $expected = true;
        $this->assertEqual($result, $expected);
    } 
	
	function testSetStatusesActive()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$result = $this->StaNoticia->setStatusesActive(array('status' => array('publicado')));
		$expected = array(
			'StaNoticia' => array(
				'status' => array(
					'field' => 'status',
					'options' => array('rascunho', 'publicado'),
					'active' => array('publicado')
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testSetStatusesActiveDefault()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$result = $this->StaNoticia->setStatusesActive(array('publicado'));
		$expected = array(
			'StaNoticia' => array(
				'status' => array(
					'field' => 'status',
					'options' => array('rascunho', 'publicado'),
					'active' => array('publicado')
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testSetStatusesActiveMultipleDefault()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$result = $this->StaNoticia->setStatusesActive(array('publicado','rascunho'));
		$expected = array(
			'StaNoticia' => array(
				'status' => array(
					'field' => 'status',
					'options' => array('rascunho', 'publicado'),
					'active' => array('publicado','rascunho')
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindAll()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$result = $this->StaNoticia->find('all');
		$expected = array(
			'0' => array(
				'StaNoticia' => array(
					'id' => '1',
					'status' => 'rascunho'
				)
			),
			'1' => array(
				'StaNoticia' => array(
					'id' => '2',
					'status' => 'publicado'
				)
			),
			'2' => array(
				'StaNoticia' => array(
					'id' => '3',
					'status' => 'rascunho'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindWithSetStatuses()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$this->StaNoticia->setStatusesActive(array('publicado'));
		$result = $this->StaNoticia->find('all');
		$expected = array(
			'0' => array(
				'StaNoticia' => array(
					'id' => '2',
					'status' => 'publicado'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindWithTwoSetStatuses()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$this->StaNoticia->setStatusesActive(array('publicado', 'rascunho'));
		$result = $this->StaNoticia->find('all');
		$expected = array(
			'0' => array(
				'StaNoticia' => array(
					'id' => '1',
					'status' => 'rascunho'
				)
			),
			'1' => array(
				'StaNoticia' => array(
					'id' => '2',
					'status' => 'publicado'
				)
			),
			'2' => array(
				'StaNoticia' => array(
					'id' => '3',
					'status' => 'rascunho'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	/*
	function testFindWithInlineActiveStatuses()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$result = $this->StaNoticia->find('all',array('conditions' => array('id' => array(1,2,3)),'active_statuses' => array('status' => array('publicado'))));
		$expected = array(
			'0' => array(
				'StaNoticia' => array(
					'id' => '2',
					'status' => 'publicado'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	*/
	
}
?> 