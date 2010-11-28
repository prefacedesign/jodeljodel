<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::import('Model', 'Cascata.AguaE');

class AguaETestCase extends CakeTestCase {

    var $fixtures = array(
        'plugin.cascata.agua_e'
    );
    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação belongsTo
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testEgetAll()
    {
        $this->AguaE =& ClassRegistry::init('Cascata.AguaE');

        $result = $this->AguaE->getAll();
        $expected = 'nome X E';
        $this->assertEqual($result[0][$this->AguaE->name]['nome'],$expected);
    }

}

?>
