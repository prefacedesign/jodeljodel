<?php

App::import('Model', 'JodelTradutore.JodelTranslatableMock');

class JodelTranslatableTestCase extends CakeTestCase {

    var $fixtures = array('plugin.jodel_tradutore.jodel_translatable_mock');
    var $JodelTranslatableMock;

    function startCase() {
        parent::startCase();
        $this->JodelTranslatableMock = ClassRegistry::init('JodelTranslatableMock');
    }

    function testSanity() {
        $expected = array(
            0 => array(
                'JodelTranslatableMock' => array(
                    'id' => 1,
                    'title' => 'Antony and Cleopatra',
                    'year' => 1606,
                    'opening_excerpt' => "Phil: Nay, but this dotage of our general's..."
                )
            ),
            1 => array(
                'JodelTranslatableMock' => array(
                    'id' => 2,
                    'title' => 'King Lear',
                    'year' => 1605,
                    'opening_excerpt' => "Earl of Kent: I thought the King had more affected the Duke of Albany than Cornwall."
                )
            ),
            2 => array(
                'JodelTranslatableMock' => array(
                    'id' => 3,
                    'title' => 'The Comedy of Errors',
                    'year' => 1589,
                    'opening_excerpt' =>
                    "Aegeon: Proceed, Solinus, to procure my fall\nAnd by the doom of death end woes and all."
                )
            ),
            3 => array(
                'JodelTranslatableMock' => array(
                    'id' => 4,
                    'title' => 'The Tragedy of Julius Caesar',
                    'year' => 1599,
                    'opening_excerpt' => "Flavius: Hence! home, you idle creatures get you home:\nIs this a holiday?"
                )
            ),
            4 => array(
                'JodelTranslatableMock' => array(
                    'id' => 5,
                    'title' => 'The Tragedy of Hamlet, Prince of Denmark',
                    'year' => 1600,
                    'opening_excerpt' => "Bernardo: Who's there?"
                )
            )
        );

        $result = $this->JodelTranslatableMock->find('all');

        $this->assertFalse(empty($result));
        $this->assertEqual($expected, $result);
    }

    function testGetSetDefaultLanguage() {
        $expected = JODEL_TRANSLATABLE_DEFAULT_LANGUAGE;
        $result = $this->JodelTranslatableMock->getDefaultLanguage();

        $this->assertEqual($expected, $result);

        $this->JodelTranslatableMock->setDefaultLanguage('es');

        $expected = 'es';
        $result = $this->JodelTranslatableMock->getDefaultLanguage();

        $this->assertEqual($expected, $result);
    }

    function testGetSetLanguage() {
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
