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
		$view =& new View(new BurocrataTestController());
		ClassRegistry::addObject('view', $view);
		$this->_appEncoding = Configure::read('App.encoding');
		$this->_asset = Configure::read('Asset');
		$this->_debug = Configure::read('debug');
	}

	function testSimpleInput()
	{
		$this->assertEqual(
			$this->BuroBurocrata->input(array(),array('name' => 'titulo', 'label' => 'Título', 'type' => 'text', 'instructions' => 'Lorem ipsum dolor eler sit.')),
			'<div class="input"><label for="titulo">Título</label><span>Lorem ipsum dolor eler sit.</span><input name="titulo" type="text" id="titulo" /></div>'
		);
		$this->assertEqual(
			$this->BuroBurocrata->input(array(),array('name' => 'titulo', 'label' => 'Título', 'type' => 'text')),
			'<div class="input"><label for="titulo">Título</label><input name="titulo" type="text" id="titulo" /></div>'
		);
	}
	
	function testNestedSimpleInputs()
	{
		$this->assertEqual(
			$this->BuroBurocrata->iinput(array(), array('type' => 'super_field', 'label' => 'Detalhes')),
			'<div class="input"><span>Detalhes</span>'
		);
		$this->assertEqual(
			$this->BuroBurocrata->input(
				array(), 
				array(
					'name' => 'gosta_da_gente',
					'label' => 'Você gosta da gente?',
					'type' => 'text',
					'instructions' => 'Seja sincero. Por favor.'
				)
			),
			'<div class="subinput"><label for="gosta_da_gente">Você gosta da gente?</label><span>Seja sincero. Por favor.</span><input name="gosta_da_gente" type="text" id="gosta_da_gente" /></div>'
		);
		$this->assertEqual(
			$this->BuroBurocrata->finput(),
			'</div>'
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