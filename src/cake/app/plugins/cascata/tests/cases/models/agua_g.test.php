<?php
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
        $expected = 'nome X G';
        $this->assertEqual($result[0][$this->AguaG->name]['nome'],$expected);
    }

}

?>
