<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::import('Model', 'Cascata.AguaC');

class AguaCTestCase extends CakeTestCase {

    var $fixtures = array(
        'plugin.cascata.agua_c',
        'plugin.cascata.agua_i',
        'plugin.cascata.agua_h'
    );
    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação belongsTo
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testCgetAll()
    {
        $this->AguaC =& ClassRegistry::init('Cascata.AguaC');

        $result = $this->AguaC->getAll();
        $expectedC = 'nome C';
        $expectedH = 'nome X H';
        $expectedI = 'nome X I';
        
        $this->assertEqual($result[0][$this->AguaC->name]['nome'],$expectedC);
        $this->assertEqual($result[0]['AguaH'][0]['nome'],$expectedH);
        $this->assertEqual($result[0]['AguaI']['nome'],$expectedI);
    }

}



?>
