<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

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
