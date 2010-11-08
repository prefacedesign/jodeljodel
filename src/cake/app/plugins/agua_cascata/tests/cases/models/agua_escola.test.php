<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::import('Model', 'AguaCascata.AguaEscola');

class AguaEscolaTestCase extends CakeTestCase {

    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testCascataAfterFind() 
    {
        $this->AguaEscola =& ClassRegistry::init('AguaCascata.AguaEscola');

        $result = $this->AguaEscola->pegaTodas();
        $expected = array(
                array(
                        'AguaEscola' => array
                            (
                              'id' => 1,
                              'nome' => 'escolinha',
                              'created' => null,
                               'modified' => null
                            )
                        ,
                        'AguaProfessor' => array(
                              'id' => 1,
                              'nome' => 'joão Pessoa Professor',
                              'agua_escola_id' => 1,
                              'created' => null,
                              'modified' => null
                            )
                    ),
                array(
                        'AguaEscola' => array
                            ( 
                              'id' => 2, 
                              'nome' => 'escolona',
                              'created' => null, 
                               'modified' => null 
                            )
                        ,
                        'AguaProfessor' => array(
                              'id' => 2,
                              'nome' => 'josé Pessoa Professor',
                              'agua_escola_id' => 2,
                              'created' => null, 
                              'modified' => null
                            )
                    )
            );


        //fazer teste aqui para verificar se a cadeia veio!
        $this->assertEqual($result,$expected);
    }
}

?>
