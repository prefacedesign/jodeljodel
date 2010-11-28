<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

App::import('Model', 'Cascata.AguaJ');

class AguaJTestCase extends CakeTestCase {

    var $fixtures = array(
        'plugin.cascata.agua_j'
    );
    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação belongsTo
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testJgetAll()
    {
        $this->AguaJ =& ClassRegistry::init('Cascata.AguaJ');

        $result = $this->AguaJ->getAll();

        $expected = array
        (
            array
                (
                    'AguaJ' => array
                        (
                            'id' => 1,
                            'nome' => 'nome X J'
                        )

                )

        );


        $this->assertEqual($result,$expected);
    }

}


?>
