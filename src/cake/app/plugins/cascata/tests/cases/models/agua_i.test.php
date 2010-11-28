<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::import('Model', 'Cascata.AguaI');

class AguaITestCase extends CakeTestCase {

    var $fixtures = array(
        'plugin.cascata.agua_i'
    );
    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação belongsTo
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testIgetAll()
    {
        $this->AguaI =& ClassRegistry::init('Cascata.AguaI');

        $result = $this->AguaI->getAll();
        $expected = 'nome X I';
        $this->assertEqual($result[0][$this->AguaI->name]['nome'],$expected);
    }

}



?>
