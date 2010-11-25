<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::import('Model', 'Cascata.AguaB');

class AguaBTestCase extends CakeTestCase {

    var $fixtures = array(
        'plugin.cascata.agua_b',
        'plugin.cascata.agua_e',
        'plugin.cascata.agua_f',
        'plugin.cascata.agua_g',
        'plugin.cascata.agua_bs_agua_g'
    );
    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação belongsTo
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testBgetAll()
    {
        $this->AguaB =& ClassRegistry::init('Cascata.AguaB');

        $result = $this->AguaB->getAll();

        $expectedB = 'nome B';
        $expectedE = 'nome X E';
        $expectedF = 'nome X F';
        $expectedG = 'nome X G';

        $this->assertEqual($result[0][$this->AguaB->name]['nome'],$expectedB);
        $this->assertEqual($result[0]['AguaE']['nome'],$expectedE);
        $this->assertEqual($result[0]['AguaF'][0]['nome'],$expectedF);
        $this->assertEqual($result[0]['AguaG'][0]['nome'],$expectedG);
    }

}



?>
