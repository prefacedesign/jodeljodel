<?php
/* BuroBurocrata Test cases generated on: 2010-11-04 18:11:25 : 1288906525*/
App::import('Core', array('Helper', 'AppHelper', 'View'));
App::import('Helper', array('Burocrata.BuroBurocrata', 'Form', 'Html', 'Ajax'));


/**
 * BurocrataTestController class
 */
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


/**
 * Contact class
 *
 */
class Contact extends CakeTestModel {

/**
 * primaryKey property
 *
 * @var string 'id'
 * @access public
 */
	var $primaryKey = 'id';

/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;

/**
 * name property
 *
 * @var string 'Contact'
 * @access public
 */
	var $name = 'Contact';

/**
 * Default schema
 *
 * @var array
 * @access public
 */
	var $_schema = array(
		'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
		'name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'email' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'phone' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'password' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'published' => array('type' => 'date', 'null' => true, 'default' => null, 'length' => null),
		'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
		'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
	);

/**
 * validate property
 *
 * @var array
 * @access public
 */
	var $validate = array(
		'non_existing' => array(),
		'idontexist' => array(),
		'imrequired' => array('rule' => array('between', 5, 30), 'allowEmpty' => false),
		'imalsorequired' => array('rule' => 'alphaNumeric', 'allowEmpty' => false),
		'imrequiredtoo' => array('rule' => 'notEmpty'),
		'required_one' => array('required' => array('rule' => array('notEmpty'))),
		'imnotrequired' => array('required' => false, 'rule' => 'alphaNumeric', 'allowEmpty' => true),
		'imalsonotrequired' => array(
			'alpha' => array('rule' => 'alphaNumeric','allowEmpty' => true),
			'between' => array('rule' => array('between', 5, 30)),
		),
		'imnotrequiredeither' => array('required' => true, 'rule' => array('between', 5, 30), 'allowEmpty' => true),
	);

/**
 * schema method
 *
 * @access public
 * @return void
 */
	function setSchema($schema) {
		$this->_schema = $schema;
	}
	
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array('User');
}


/**
 * UserForm class
 *
 */
class User extends CakeTestModel {

/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;

/**
 * primaryKey property
 *
 * @var string 'id'
 * @access public
 */
	var $primaryKey = 'id';

/**
 * name property
 *
 * @var string 'UserForm'
 * @access public
 */
	var $name = 'User';

/**
 * schema definition
 *
 * @var array
 * @access protected
 */
	var $_schema = array(
		'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
		'published' => array('type' => 'date', 'null' => true, 'default' => null, 'length' => null),
		'other' => array('type' => 'text', 'null' => true, 'default' => null, 'length' => null),
		'stuff' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'something' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 255),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => false),
		'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
		'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
	);
}




/**
 * BuroBurocrataHelperTest class
 */
class BuroBurocrataHelperTest extends CakeTestCase {

/**
 * setUp method
 *
 * @access public
 * @return void
 */
	function setUp() {
		parent::setUp();
		Router::reload();

		$this->BuroBurocrata =& new BuroBurocrataHelper();
		$this->BuroBurocrata->Form =& new FormHelper();
		$this->BuroBurocrata->Form->Html =& new HtmlHelper();
		$this->BuroBurocrata->Ajax =& new AjaxHelper();
		$this->BuroBurocrata->Ajax =& $this->BuroBurocrata->Form;
		
		$this->View =& new View(new BurocrataTestController());
		ClassRegistry::addObject('view', $this->View);
		
		ClassRegistry::addObject('User', new User());
		ClassRegistry::addObject('Contact', new Contact());
		
		$this->_appEncoding = Configure::read('App.encoding');
		$this->_asset = Configure::read('Asset');
		$this->_debug = Configure::read('debug');
	}

	
	function testBasicForm()
	{
		$encoding = strtolower(Configure::read('App.encoding'));
		
		$result = $this->BuroBurocrata->iform(array(), array('url' => '/news/add'));
		$expected = array(
			'div' => array('id' => 'preg:/frm[0-9a-f]{13,13}/', 'class' => 'form')
		);
		// $this->assertTags($result, $expected);
		
		
		$this->assertTags(
			$this->BuroBurocrata->fform(),
			array('/div')
		);
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
				'input' => array('name' => 'data[titulo]', 'type' => 'text', 'id' => 'titulo'),
			'/div'
		);
		$this->assertTags($result, $expected);
		
		
		$result = $this->BuroBurocrata->input(array(),array('name' => 'titulo_id'));
		$expected = array(
			'div' => array('class' => 'input'),
				'label' => array('for' => 'titulo_id'),
					'Titulo',
				'/label',
				'input' => array('name' => 'data[titulo_id]', 'type' => 'text', 'id' => 'titulo_id'),
			'/div'
		);
		$this->assertTags($result, $expected);
		
		
		$result = $this->BuroBurocrata->input(array(),array('name' => 'titulo'));
		$expected = array(
			'div' => array('class' => 'input'),
				'label' => array('for' => 'titulo'),
					'Titulo',
				'/label',
				'input' => array('name' => 'data[titulo]', 'type' => 'text', 'id' => 'titulo'),
			'/div'
		);
		$this->assertTags($result, $expected);
		
		
		$result = $this->BuroBurocrata->input(array(),array('name' => 'Model.titulo'));
		$expected = array(
			'div' => array('class' => 'input'),
				'label' => array('for' => 'ModelTitulo'),
					'Titulo',
				'/label',
				'input' => array('name' => 'data[Model][titulo]', 'type' => 'text', 'id' => 'ModelTitulo'),
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
				'input' => array('name' => 'data[gosta_da_gente]', 'type' => 'text', 'id' => 'gosta_da_gente'),
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
	
	function testBelongsToInput()
	{
		$this->BuroBurocrata->iform(array(), array('model' => 'Contact', 'url' => '/users/add'));
		
		$result = $this->BuroBurocrata->input(
			array(),
			array('type' => 'belongsTo')
			);
		$expected = array(
			'div' => array('class' => 'input'),
			'/div');
		// $this->assertTags($result, $expected);
		
		$result = $this->BuroBurocrata->input(
			array(),
			array(
				'type' => 'belongsTo',
				'instructions' => 'Lorem ipsum!',
				'options' => array(
					'model' => 'User'
				)
			)
		);
		$expected = array(
			'div' => array('class' => 'input'),
				'input' => array('type' => 'hidden', 'name' => 'data[Contact][user_id]', 'id' => 'ContactUserId'),
				'label' => array('for' => 'preg:/blt[0-9a-f]{13,13}/'),
					'User',
				'/label',
				'span' => array(),
					'Lorem ipsum!',
				'/span',
				'belongsToAutocomplete' => array('id' => 'preg:/blt[0-9a-f]{13,13}/'),
			'/div'
		);
		// $this->assertTags($result, $expected);
		// debug(h($result));
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