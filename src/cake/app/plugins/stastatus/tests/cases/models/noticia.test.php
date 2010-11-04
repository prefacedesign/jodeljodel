<?php 
App::import('Model','Stastatus.Noticia');

class NoticiaTestCase extends CakeTestCase {
    var $fixtures = array('plugin.stastatus.noticia');
	
	function testChangeStatus() 
	{
        $this->Noticia =& ClassRegistry::init('Noticia');
        $result = $this->Noticia->changeStatus(1, array('status' => 'publicado'), false);
        $expected = true;
        $this->assertEqual($result, $expected);
    } 
	
	function testSetStatusesActive()
	{
		$this->Noticia =& ClassRegistry::init('Noticia');
		$result = $this->Noticia->setStatusesActive(array('status' => array('publicado')));
		$expected = array(
			'Noticia' => array(
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
		$this->Noticia =& ClassRegistry::init('Noticia');
		$result = $this->Noticia->setStatusesActive(array('publicado'));
		$expected = array(
			'Noticia' => array(
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
		$this->Noticia =& ClassRegistry::init('Noticia');
		$result = $this->Noticia->setStatusesActive(array('publicado','rascunho'));
		$expected = array(
			'Noticia' => array(
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
		$this->Noticia =& ClassRegistry::init('Noticia');
		$result = $this->Noticia->find('all');
		$expected = array(
			'0' => array(
				'Noticia' => array(
					'id' => '1',
					'status' => 'rascunho'
				)
			),
			'1' => array(
				'Noticia' => array(
					'id' => '2',
					'status' => 'publicado'
				)
			),
			'2' => array(
				'Noticia' => array(
					'id' => '3',
					'status' => 'rascunho'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindWithSetStatuses()
	{
		$this->Noticia =& ClassRegistry::init('Noticia');
		$this->Noticia->setStatusesActive(array('publicado'));
		$result = $this->Noticia->find('all');
		$expected = array(
			'0' => array(
				'Noticia' => array(
					'id' => '2',
					'status' => 'publicado'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindWithInlineActiveStatuses()
	{
		$this->Noticia =& ClassRegistry::init('Noticia');
		$result = $this->Noticia->find('all',array('conditions' => array('id' => array(1,2,3)),'active_statuses' => array('status' => array('publicado'))));
		$expected = array(
			'0' => array(
				'Noticia' => array(
					'id' => '2',
					'status' => 'publicado'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	
}
?> 