<?php

/**
 * Test case class for Translatable behavior.
 *
 * @copyright  Copyright 2010, Preface Design
 * @link       http://www.preface.com.br/
 * @license    MIT License <http://www.opensource.org/licenses/mit-license.php> - redistributions of files must retain the copyright notice
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 *
 * @author     Bruno Franciscon Mazzotti <mazzotti@preface.com.br>
 * @version    Jodel Jodel 0.1
 * @since      11. Nov. 2010
 */

App::import('Model', 'Tradutore.TranslatableMock');


/**
 * Test case for Translatable behavior. The test are perfomed via mock object
 * TranslatableMock.
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 */

class TranslatableTestCase extends CakeTestCase
{
    var $fixtures = array(
        'plugin.tradutore.translatable_mock'
    );
    
    var $TranslatableMock;


    function startCase()
    {
        parent::startCase();
        $this->TranslatableMock = ClassRegistry::init('TranslatableMock');
    }


    function testFixturesSanity()
    {
        $this->TranslatableMock->Behaviors->detach('Tradutore.Translatable');

        $expected = array(
            0 => array(
                'TranslatableMock' => array(
                    'id' => 1,
                    'title' => 'Antony and Cleopatra',
                    'year' => 1606,
                    'opening_excerpt' => "Phil: Nay, but this dotage of our general's..."
                )
            ),
            1 => array(
                'TranslatableMock' => array(
                    'id' => 2,
                    'title' => 'King Lear',
                    'year' => 1605,
                    'opening_excerpt' => "Earl of Kent: I thought the King had more affected the Duke of Albany than Cornwall."
                )
            ),
            2 => array(
                'TranslatableMock' => array(
                    'id' => 3,
                    'title' => 'The Comedy of Errors',
                    'year' => 1589,
                    'opening_excerpt' =>
                    "Aegeon: Proceed, Solinus, to procure my fall\nAnd by the doom of death end woes and all."
                )
            ),
            3 => array(
                'TranslatableMock' => array(
                    'id' => 4,
                    'title' => 'The Tragedy of Julius Caesar',
                    'year' => 1599,
                    'opening_excerpt' => "Flavius: Hence! home, you idle creatures get you home:\nIs this a holiday?"
                )
            ),
            4 => array(
                'TranslatableMock' => array(
                    'id' => 5,
                    'title' => 'The Tragedy of Hamlet, Prince of Denmark',
                    'year' => 1600,
                    'opening_excerpt' => "Bernardo: Who's there?"
                )
            )
        );

        $result = $this->TranslatableMock->find('all');

        $this->assertFalse(empty($result));
        $this->assertEqual($expected, $result);

        $this->TranslatableMock->Behaviors->attach('Tradutore.Translatable');
    }


    function testGetSetDefaultLanguage()
    {
        $expected = Configure::read('Tradutore.default_language');
        $result = $this->TranslatableMock->getDefaultLanguage();

        $this->assertEqual($expected, $result);

        $this->TranslatableMock->setDefaultLanguage('es');

        $expected = 'es';
        $result = $this->TranslatableMock->getDefaultLanguage();

        $this->assertEqual($expected, $result);
    }


    function testGetSetLanguage()
    {
        $expected = Configure::read('Tradutore.default_language');
        $result = $this->TranslatableMock->getLanguage();

        $this->assertEqual($expected, $result);

        $this->TranslatableMock->setLanguage('pt-br');

        $expected = 'pt-br';
        $result = $this->TranslatableMock->getLanguage();

        $this->assertEqual($expected, $result);
    }


    function testLanguageInsertion()
    {
        $expected = array(
            'TranslatableMock' => array(
                'title' => 'King Lear',
                'year' => 1605,
                'language' => $this->TranslatableMock->getLanguage()
            )
        );

        $result = $this->TranslatableMock->find(
            'first',
            array(
                'fields' => array ('title', 'year'),
                'conditions' => array('id' => 2)
            )
        );
        
        $this->assertEqual($expected, $result);
    }

}

?>
