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

App::import('Model','Status.StaNoticia');

class StaNoticiaTestCase extends CakeTestCase {
    var $fixtures = array('plugin.status.sta_noticia');
	
	function testSetStatus() 
	{
        $this->StaNoticia =& ClassRegistry::init('StaNoticia');
        $result = $this->StaNoticia->setStatus(1, array('status' => 'publicado'));
        $expected = true;
        $this->assertEqual($result, $expected);
    } 
	
	function testSetActiveStatuses()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$result = $this->StaNoticia->setActiveStatuses(array('status' => array('rascunho')));
		$expected = array(
			'StaNoticia' => array(
				'status' => array(
					'field' => 'status',
					'options' => array('rascunho', 'publicado'),
					'active' => array('rascunho')
				)
			)
		);
		$this->assertEqual($result, $expected);
	}
	
	
	function testSetActiveStatusesDefaultWhenYouHaveOnlyOneStatusFieldInTheModel()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$result = $this->StaNoticia->setActiveStatuses(array('publicado'));
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
	
	function testSetTwoActiveStatusesDefaultWhenYouHaveOnlyOneStatusFieldInTheModel()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$result = $this->StaNoticia->setActiveStatuses(array('publicado','rascunho'));
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
		//debug($result);
		$expected = array(
			'0' => array(
				'StaNoticia' => array('id' => '1','status' => 'rascunho')),
			'1' => array(
				'StaNoticia' => array('id' => '2','status' => 'publicado')),
			'2' => array(
				'StaNoticia' => array('id' => '3','status' => 'rascunho')),
			'3' => array(
				'StaNoticia' => array('id' => '4','status' => 'rascunho')),
			'4' => array(
				'StaNoticia' => array('id' => '5','status' => 'publicado')),
			'5' => array(
				'StaNoticia' => array('id' => '6','status' => 'rascunho')),
			'6' => array(
				'StaNoticia' => array('id' => '7','status' => 'rascunho')),
			'7' => array(
				'StaNoticia' => array('id' => '8','status' => 'publicado')),
			'8' => array(
				'StaNoticia' => array('id' => '9','status' => 'rascunho')),
			'9' => array(
				'StaNoticia' => array('id' => '10','status' => 'publicado')),
			'10' => array(
				'StaNoticia' => array('id' => '12','status' => 'rascunho')),
			'11' => array(
				'StaNoticia' => array('id' => '15','status' => 'rascunho')),
			'12' => array(
				'StaNoticia' => array('id' => '16','status' => 'publicado')),
			'13' => array(
				'StaNoticia' => array('id' => '22','status' => 'publicado'))
		);
		$this->assertEqual($result, $expected);
	}
	
	function testFindWithSetStatusesPerformedBefore()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$this->StaNoticia->setActiveStatuses(array('publicado'));
		$result = $this->StaNoticia->find('all');
		$expected = array(
			'0' => array(
				'StaNoticia' => array('id' => '2','status' => 'publicado')),
			'1' => array(
				'StaNoticia' => array('id' => '5','status' => 'publicado')),
			'2' => array(
				'StaNoticia' => array('id' => '8','status' => 'publicado')),
			'3' => array(
				'StaNoticia' => array('id' => '10','status' => 'publicado')),
			'4' => array(
				'StaNoticia' => array('id' => '16','status' => 'publicado')),
			'5' => array(
				'StaNoticia' => array('id' => '22','status' => 'publicado'))
		);
		$this->assertEqual($result, $expected);
	}
	
	
	function testFindWithTwoSetStatusesPerformedBefore()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$this->StaNoticia->setActiveStatuses(array('publicado', 'rascunho'));
		$result = $this->StaNoticia->find('all');
		$expected = array(
			'0' => array(
				'StaNoticia' => array('id' => '1','status' => 'rascunho')),
			'1' => array(
				'StaNoticia' => array('id' => '2','status' => 'publicado')),
			'2' => array(
				'StaNoticia' => array('id' => '3','status' => 'rascunho')),
			'3' => array(
				'StaNoticia' => array('id' => '4','status' => 'rascunho')),
			'4' => array(
				'StaNoticia' => array('id' => '5','status' => 'publicado')),
			'5' => array(
				'StaNoticia' => array('id' => '6','status' => 'rascunho')),
			'6' => array(
				'StaNoticia' => array('id' => '7','status' => 'rascunho')),
			'7' => array(
				'StaNoticia' => array('id' => '8','status' => 'publicado')),
			'8' => array(
				'StaNoticia' => array('id' => '9','status' => 'rascunho')),
			'9' => array(
				'StaNoticia' => array('id' => '10','status' => 'publicado')),
			'10' => array(
				'StaNoticia' => array('id' => '12','status' => 'rascunho')),
			'11' => array(
				'StaNoticia' => array('id' => '15','status' => 'rascunho')),
			'12' => array(
				'StaNoticia' => array('id' => '16','status' => 'publicado')),
			'13' => array(
				'StaNoticia' => array('id' => '22','status' => 'publicado'))
		);
		$this->assertEqual($result, $expected);
	}
	
	
	function testFindWithInlineActiveStatuses()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$result = $this->StaNoticia->find('all',array('conditions' => array('id' => array(1,2,3,4,5,6,7,8,9,10)),'active_statuses' => array('status' => array('publicado'))));
		$expected = array(
			'0' => array(
				'StaNoticia' => array('id' => '2','status' => 'publicado')),
			'1' => array(
				'StaNoticia' => array('id' => '5','status' => 'publicado')),
			'2' => array(
				'StaNoticia' => array('id' => '8','status' => 'publicado')),
			'3' => array(
				'StaNoticia' => array('id' => '10','status' => 'publicado'))
		);
		$this->assertEqual($result, $expected);
	}
	
	
	function testFindAllAfterASeekWithInlineActiveStatuses()
	{
		$this->StaNoticia =& ClassRegistry::init('StaNoticia');
		$result = $this->StaNoticia->find('all');
		$expected = array(
			'0' => array(
				'StaNoticia' => array('id' => '1','status' => 'rascunho')),
			'1' => array(
				'StaNoticia' => array('id' => '2','status' => 'publicado')),
			'2' => array(
				'StaNoticia' => array('id' => '3','status' => 'rascunho')),
			'3' => array(
				'StaNoticia' => array('id' => '4','status' => 'rascunho')),
			'4' => array(
				'StaNoticia' => array('id' => '5','status' => 'publicado')),
			'5' => array(
				'StaNoticia' => array('id' => '6','status' => 'rascunho')),
			'6' => array(
				'StaNoticia' => array('id' => '7','status' => 'rascunho')),
			'7' => array(
				'StaNoticia' => array('id' => '8','status' => 'publicado')),
			'8' => array(
				'StaNoticia' => array('id' => '9','status' => 'rascunho')),
			'9' => array(
				'StaNoticia' => array('id' => '10','status' => 'publicado')),
			'10' => array(
				'StaNoticia' => array('id' => '12','status' => 'rascunho')),
			'11' => array(
				'StaNoticia' => array('id' => '15','status' => 'rascunho')),
			'12' => array(
				'StaNoticia' => array('id' => '16','status' => 'publicado')),
			'13' => array(
				'StaNoticia' => array('id' => '22','status' => 'publicado'))
		);
		$this->assertEqual($result, $expected);
	}
	
}
?> 