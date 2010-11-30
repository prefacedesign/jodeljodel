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


        $expected = array
        (
            array
                (
                    'AguaB' => array
                        (
                            'id' => 1,
                            'nome' => 'nome Y B',
                            'agua_a_id' => 1
                        ),

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

        );

        $this->assertEqual($result,$expected);
    }

}



?>
