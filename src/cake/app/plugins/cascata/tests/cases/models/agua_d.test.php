<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

App::import('Model', 'Cascata.AguaD');

class AguaDTestCase extends CakeTestCase {

    var $fixtures = array(
        'plugin.cascata.agua_j',
        'plugin.cascata.agua_d'
    );
    
    function testDgetAll()
    {
        $this->AguaD =& ClassRegistry::init('Cascata.AguaD');

        $result = $this->AguaD->getAll();

        $expectedD = 'nome Y D';
        $expectedJ = 'nome X J';
        
        $this->assertEqual($result[0][$this->AguaD->name]['nome'],$expectedD);
        $this->assertEqual($result[0]['AguaJ']['nome'],$expectedJ);
    }
}


?>
