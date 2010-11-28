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

        $expected = array
        (
            array
                (
                    'AguaD' => array
                        (
                            'id' => 1,
                            'nome' => 'nome Y D',
                            'agua_j_id' => 1
                        ),

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
