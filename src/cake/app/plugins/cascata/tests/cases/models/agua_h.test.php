<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::import('Model', 'Cascata.AguaH');

class AguaHTestCase extends CakeTestCase {

    var $fixtures = array(
        'plugin.cascata.agua_h'
    );
    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação belongsTo
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testHgetAll()
    {
        $this->AguaH =& ClassRegistry::init('Cascata.AguaH');

        $result = $this->AguaH->getAll();

        $expected = array
        (
            array
                (
                    'AguaH' => array
                        (
                            'id' => 1,
                            'nome' => 'nome X H',
                            'agua_c_id' => 1
                        )

                )

        );

        $this->assertEqual($result,$expected);
    }

}

?>
