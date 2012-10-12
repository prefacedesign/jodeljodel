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

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::import('Model', 'Cascata.AguaG');

class AguaGTestCase extends CakeTestCase {

    var $fixtures = array(
        'plugin.cascata.agua_g'
    );
    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação belongsTo
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testGgetAll()
    {
        $this->AguaG =& ClassRegistry::init('Cascata.AguaG');

        $result = $this->AguaG->getAll();
        
        $expected = array
        (
            array
                (
                    'AguaG' => array
                        (
                            'id' => 1,
                            'nome' => 'nome X G'
                        )

                )

        );

        $this->assertEqual($result, $expected);
    }

}

?>
