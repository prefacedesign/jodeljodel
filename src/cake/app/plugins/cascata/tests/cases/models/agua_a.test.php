<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

App::import('Model', 'Cascata.AguaA');

class AguaATestCase extends CakeTestCase {

    var $fixtures = array(
        'plugin.cascata.agua_a',
        'plugin.cascata.agua_d',
        'plugin.cascata.agua_b',
        'plugin.cascata.agua_as_agua_c',
        'plugin.cascata.agua_j',
        'plugin.cascata.agua_e',
        'plugin.cascata.agua_f',
        'plugin.cascata.agua_bs_agua_g',
        'plugin.cascata.agua_c',
        'plugin.cascata.agua_i',
        'plugin.cascata.agua_h',
        'plugin.cascata.agua_g'
    );
    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação belongsTo
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
/*    function testAgetAll()
    {
        $this->AguaA =& ClassRegistry::init('Cascata.AguaA');

        $result = $this->AguaA->getAll();

        $expectedA = 'nome A';
        $expectedD = 'nome D';
        $expectedB = 'nome B';
        $expectedC = 'nome C';

        $this->assertEqual($result[0][$this->AguaA->name]['nome'],$expectedA);
        $this->assertEqual($result[0]['AguaD']['nome'],$expectedD);
        $this->assertEqual($result[0]['AguaB'][0]['nome'],$expectedB);
        $this->assertEqual($result[0]['AguaC'][0]['nome'],$expectedC);
    }
*/
    /*
     * Função para testar o getAll do model A com recursive = 2
     * este teste serve para verificar se o cascateamento está ocorrendo
     * com um nível > 1
     */
    function testAgetAllRecursive2()
    {
        $this->AguaA =& ClassRegistry::init('Cascata.AguaA');

        $result = $this->AguaA->getAllRecursive2();

        $expectedA = 'nome A';

        $expectedD = 'nome D';
        $expectedDJ = 'nome X J';

        $expectedB = 'nome B';
        $expectedBE = 'nome X E';
        $expectedBF = 'nome X F';
        $expectedBG = 'nome X G';

        $expectedC = 'nome C';
        $expectedCI = 'nome X I';
        $expectedCH = 'nome X H';

        $this->assertEqual($result[0][$this->AguaA->name]['nome'],$expectedA);
        
        $this->assertEqual($result[0]['AguaD']['nome'],$expectedD);
        $this->assertEqual($result[0]['AguaD']['AguaJ']['nome'],$expectedDJ);

        $this->assertEqual($result[0]['AguaB'][0]['nome'],$expectedB);
        $this->assertEqual($result[0]['AguaB'][0]['AguaE']['nome'],$expectedBE);
        $this->assertEqual($result[0]['AguaB'][0]['AguaF'][0]['nome'],$expectedBF);
        $this->assertEqual($result[0]['AguaB'][0]['AguaG'][0]['nome'],$expectedBG);

        $this->assertEqual($result[0]['AguaC'][0]['nome'],$expectedC);
        $this->assertEqual($result[0]['AguaC'][0]['AguaI']['nome'],$expectedCI);
        $this->assertEqual($result[0]['AguaC'][0]['AguaH'][0]['nome'],$expectedCH);
    }

}

?>
