<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

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
    function testAgetAll()
    {
        $this->AguaA =& ClassRegistry::init('Cascata.AguaA');

        $result = $this->AguaA->getAll();

        

        $expected = array
        (
            array
                (
                    'AguaA' => array
                        (
                            'id' => 1,
                            'nome' => 'nome Y A',
                            'agua_d_id' => 1
                        ),

                    'AguaD' => array
                        (
                            'id' => 1,
                            'nome' => 'nome Y D',
                            'agua_j_id' => 1
                        ),

                    'AguaB' => array
                        (
                            array
                                (
                                    'id' => 1,
                                    'nome' => 'nome Y B',
                                    'agua_a_id' => 1
                                )

                        ),

                    'AguaC' => array
                        (
                            array
                                (
                                    'id' => 1,
                                    'nome' => 'nome Y C',
                                    'AguaAsAguaC' => array
                                        (
                                            'id' => 1,
                                            'agua_a_id' => 1,
                                            'agua_c_id' => 1
                                        )

                                )

                        )

                )

        );

        $this->assertEqual($result,$expected);
    }

    /*
     * Função para testar o getAll do model A com recursive = 2
     * este teste serve para verificar se o cascateamento está ocorrendo
     * com um nível = 2
     */
    function testAgetAllRecursive2()
    {
        $this->AguaA =& ClassRegistry::init('Cascata.AguaA');

        $result = $this->AguaA->getAllRecursive2();
        
        $expected = array
        (
            array
                (
                    'AguaA' => array
                        (
                            'id' => 1,
                            'nome' => 'nome Y A',
                            'agua_d_id' => 1
                        ),

                    'AguaD' => array
                        (
                            'id' => 1,
                            'nome' => 'nome Y D',
                            'agua_j_id' => 1,
                            'AguaJ' => array
                                (
                                    'id' => 1,
                                    'nome' => 'nome X J'
                                )

                        ),

                    'AguaB' => array
                        (
                            array
                                (
                                    'id' => 1,
                                    'nome' => 'nome Y B',
                                    'agua_a_id' => 1,
                                    'AguaE' => array
                                        (
                                            'id' => 1,
                                            'nome' => 'nome X E',
                                            'agua_b_id' => 1
                                        ),

                                    'AguaF' => array
                                        (
                                            array
                                                (
                                                    'id' => 1,
                                                    'nome' => 'nome X F',
                                                    'agua_b_id' => 1
                                                )

                                        ),

                                    'AguaG' => array
                                        (
                                            array
                                                (
                                                    'id' => 1,
                                                    'nome' => 'nome X G',
                                                    'AguaBsAguaG' => array
                                                        (
                                                            'id' => 1,
                                                            'agua_b_id' => 1,
                                                            'agua_g_id' => 1
                                                        )

                                                )

                                        )

                                )

                        ),

                    'AguaC' => array
                        (
                            array
                                (
                                    'id' => 1,
                                    'nome' => 'nome Y C',
                                    'AguaAsAguaC' => array
                                        (
                                            'id' => 1,
                                            'agua_a_id' => 1,
                                            'agua_c_id' => 1
                                        ),

                                    'AguaI' => array
                                        (
                                            'id' => 1,
                                            'nome' => 'nome X I',
                                            'agua_c_id' => 1
                                        ),

                                    'AguaH' => array
                                        (
                                            array
                                                (
                                                    'id' => 1,
                                                    'nome' => 'nome X H',
                                                    'agua_c_id' => 1
                                                )

                                        )

                                )

                        )

                )

        );


        $this->assertEqual($result,$expected);
    }


    /*
     * Teste simples usando containable
     */
    function testAgetOnlyA()
    {
        $this->AguaA =& ClassRegistry::init('Cascata.AguaA');

        $result = $this->AguaA->getOnlyA();

        $expected = array(
                array(
                        'AguaA' => array (
                            'id' => 1,
                            'nome' => 'nome Y A',
                            'agua_d_id' => 1,

                         )
                    )
            );


        $this->assertEqual($result,$expected);


    }

    /*
     * Teste usando containable descendo 1 nível
     */
    function testAgetOnlyAandB()
    {
        $this->AguaA =& ClassRegistry::init('Cascata.AguaA');

        $result = $this->AguaA->getOnlyAandB();
        $expected = array(
                array(
                        'AguaA' => array (
                            'id' => 1,
                            'nome' => 'nome Y A',
                            'agua_d_id' => 1,

                         ),
                         'AguaB' => Array
                            (
                                array
                                    (
                                        'id' => 1,
                                        'nome' => 'nome Y B',
                                        'agua_a_id' => 1
                                    )

                            )

                    )
            );


        $this->assertEqual($result,$expected);


    }


    /*
     * Teste usando containable descendo 2 níveis
     */
    function testAgetOnlyAandBandG()
    {
        $this->AguaA =& ClassRegistry::init('Cascata.AguaA');

        $result = $this->AguaA->getOnlyAandBandG();

        $expected = array(
                array(
                        'AguaA' => array (
                            'id' => 1,
                            'nome' => 'nome Y A',
                            'agua_d_id' => 1,

                         ),
                         'AguaB' => Array
                            (
                                array
                                    (
                                        'id' => 1,
                                        'nome' => 'nome Y B',
                                        'agua_a_id' => 1,
                                        'AguaG' => array(                                 (
                                            array
                                                (
                                                    'id' => 1,
                                                    'nome' => 'nome X G',
                                                    'AguaBsAguaG' => array
                                                        (
                                                            'id' => 1,
                                                            'agua_b_id' => 1,
                                                            'agua_g_id' => 1
                                                        )

                                                )

                                        )

                                    )

                            )

                    )
                )
              );


        $this->assertEqual($result,$expected);


    }


    /*
     * Teste usando containable descendo 1 nível e limitando 1 campo
     * o retorno da chamada vem com um campo que poderia ser considerado
     * 'errado', que é o 'nome' => 'Y B',porém ele vem por fazer parte
     * de uma verificação para ver se não tem nenhum model sendo chamado
     * sem necessidade
     * @todo: pensar em uma maneira de realizar o teste de limitar
     * os atributos sem ficar com esse 'erro'
     */
    function testAgetOnlyAandBwithId()
    {
        $this->AguaA =& ClassRegistry::init('Cascata.AguaA');

        $result = $this->AguaA->getOnlyAandBwithId();
        $expected = array(
                array(
                        'AguaA' => array (
                            'id' => 1,
                            'nome' => 'nome Y A',
                            'agua_d_id' => 1,

                         ),
                         'AguaB' => Array
                            (
                                array
                                    (
                                        'id' => 1,
                                        'agua_a_id' => 1
                                    ),
                                'nome' => 'Y B'

                            )

                    )
            );


        $this->assertEqual($result,$expected);


    }

    /*
     * Teste usando containable descendo 1 nível e limitando 1 campo
     * aqui ocorre o mesmo problema do anterior, o campo nome de J
     * não deveria vir, porém vem devido ao mecanismo de teste
     * pra verificar se não está chamando models/behaviors a toa
     * @todo: pensar em uma maneira de realizar o teste de limitar
     * os atributos sem ficar com esse 'erro'
     */
    function testAgetOnlyAandDandJ()
    {
        $this->AguaA =& ClassRegistry::init('Cascata.AguaA');

        $result = $this->AguaA->getOnlyAandDandJ();
        
        $expected = array(
                array(
                        'AguaA' => array (
                            'id' => 1,
                            'nome' => 'nome Y A',
                            'agua_d_id' => 1,

                         ),
                         'AguaD' => array
                            (

                                'id' => 1,
                                'nome' => 'nome Y D',
                                'agua_j_id' => 1,
                                'AguaJ' => array
                                (
                                    'id' => 1,
                                    'nome' => 'X J'
                                )
                            )

                    )
            );

        $this->assertEqual($result,$expected);


    }

}

?>
