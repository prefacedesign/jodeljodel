<?php

App::import('Model', 'JodelTradutore.JodelTranslatableMock');

class JodelTranslatableTestCase extends CakeTestCase {

    var $fixtures = array('plugin.jodel_tradutore.jodel_translatable_mock_fixture');

    var $JodelTranslatableMock;
        
    function testGetSetDefaultLanguage() {
        $this->JodelTranslatableMock =& ClassRegistry::init('JodelTranslatableMock');
        
        $expected = JODEL_TRANSLATABLE_DEFAULT_LANGUAGE;
        $result = $this->JodelTranslatableMock->getDefaultLanguage();

        $this->assertEqual($expected, $result);

        $this->JodelTranslatableMock->setDefaultLanguage('es');

        $expected = 'es';
        $result = $this->JodelTranslatableMock->getDefaultLanguage();

        $this->assertEqual($expected, $result);
    }

    function testGetSetLanguage() {
        $this->JodelTranslatableMock =& ClassRegistry::init('JodelTranslatableMock');
        
        $expected = JODEL_TRANSLATABLE_DEFAULT_LANGUAGE;
        $result = $this->JodelTranslatableMock->getLanguage();

        $this->assertEqual($expected, $result);

        $this->JodelTranslatableMock->setLanguage('pt-br');

        $expected = 'pt-br';
        $result = $this->JodelTranslatableMock->getLanguage();

        $this->assertEqual($expected, $result);
    }

}

?>
