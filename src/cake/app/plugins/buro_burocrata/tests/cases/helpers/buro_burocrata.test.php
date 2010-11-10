<?php
/* BuroBurocrata Test cases generated on: 2010-11-04 18:11:25 : 1288906525*/
App::import('Core', array('Helper', 'AppHelper', 'View'));
App::import('Helper', array('BuroBurocrata.BuroBurocrata', 'Form', 'Html'));

class BurocrataTestController extends Controller {

/**
 * name property
 *
 * @var string 'TheTest'
 * @access public
 */
	var $name = 'BurocrataTest';

/**
 * uses property
 *
 * @var mixed null
 * @access public
 */
	var $uses = null;
}

class BuroBurocrataHelperTestCase extends CakeTestCase {
	function startTest() {
		$this->BuroBurocrata =& new BuroBurocrataHelper();
		$this->BuroBurocrata->Form =& new FormHelper();
		$this->BuroBurocrata->Form->Html =& new HtmlHelper();
		
		$this->View =& new View(new BurocrataTestController());
		ClassRegistry::addObject('view', $this->View);
		
		$this->_appEncoding = Configure::read('App.encoding');
		$this->_asset = Configure::read('Asset');
		$this->_debug = Configure::read('debug');
	}

	function testSimpleInput()
	{
		$result = $this->BuroBurocrata->input(array(),array('name' => 'titulo', 'label' => 'Título', 'type' => 'text', 'instructions' => 'Lorem ipsum dolor eler sit.'));
		$expected = array(
			'div' => array('class' => 'input'),
				'label' => array('for' => 'titulo'),
					'Título',
				'/label',
				'span' => array(),
					'Lorem ipsum dolor eler sit.',
				'/span',
				'input' => array('name' => 'titulo', 'type' => 'text', 'id' => 'titulo'),
			'/div'
		);
		$this->assertTags($result, $expected);
		
		$result = $this->BuroBurocrata->input(array(),array('name' => 'titulo', 'label' => 'Título'));
		$expected = array(
			'div' => array('class' => 'input'),
				'label' => array('for' => 'titulo'),
					'Título',
				'/label',
				'input' => array('name' => 'titulo', 'type' => 'text', 'id' => 'titulo'),
			'/div'
		);
		$this->assertTags($result, $expected);
	}
	
	function testNestedSimpleInputs()
	{
		$expected = array(
			'div' => array('class' => 'input'),
			'span' => array(),
				'Detalhes'
		);
		$result = $this->BuroBurocrata->iinput(array(), array('type' => 'super_field', 'label' => 'Detalhes'));
		$this->assertTags($result, $expected);
		
		$expected = array(
			'div' => array('class' => 'subinput'),
				'label' => array('for' => 'gosta_da_gente'),
					'Você gosta da gente?',
				'/label',
				'span' => array(),
					'Seja sincero. Por favor.',
				'/span',
				'input' => array('name' => 'gosta_da_gente', 'type' => 'text', 'id' => 'gosta_da_gente'),
			'/div'
		);
		$result = $this->BuroBurocrata->input(
				array(), 
				array(
					'name' => 'gosta_da_gente',
					'label' => 'Você gosta da gente?',
					'type' => 'text',
					'instructions' => 'Seja sincero. Por favor.'
				)
			);
		$this->assertTags($result, $expected);
		
		
		$this->assertTags(
			$this->BuroBurocrata->finput(),
			array('/div')
		);
	}
	
	function endTest() {
		Configure::write('App.encoding', $this->_appEncoding);
		Configure::write('Asset', $this->_asset);
		Configure::write('debug', $this->_debug);
		ClassRegistry::flush();
		unset($this->BuroBurocrata);
	}

}
?>