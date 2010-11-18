<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

App::import('Model', 'Cascata.AguaJ');

class AguaJTestCase extends CakeTestCase {

    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação belongsTo
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testJ1()
    {
        $this->AguaJ =& ClassRegistry::init('Cascata.AguaJ');

        $result = $this->AguaJ->getAll();
        debug($result);
//        $this->assertEqual($result,$expected);
    }
}


?>
