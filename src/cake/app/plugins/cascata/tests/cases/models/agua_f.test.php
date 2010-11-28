<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::import('Model', 'Cascata.AguaF');

class AguaFTestCase extends CakeTestCase {

    var $fixtures = array(
        'plugin.cascata.agua_f'
    );
    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação belongsTo
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testFgetAll()
    {
        $this->AguaF =& ClassRegistry::init('Cascata.AguaF');

        $result = $this->AguaF->getAll();
        $expected = 'nome X F';
        $this->assertEqual($result[0][$this->AguaF->name]['nome'],$expected);
    }

}

?>
