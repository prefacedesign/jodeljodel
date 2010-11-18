<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::import('Model', 'Cascata.AguaEquipe');

class AguaEquipeTestCase extends CakeTestCase {

    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação HasOne
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testCascataHasOneAfterFind()
    {
        $this->AguaEquipe =& ClassRegistry::init('Cascata.AguaEquipe');

        $result = $this->AguaEquipe->pegaTodas();
        $expected = array(
                array(
                        'AguaEquipe' => array
                            (
                              'id' => 1,
                              'nome' => 'a grande',
                              'created' => null,
                               'modified' => null
                            )
                        ,
                        'AguaProfessor' => array (
                          'id' => 1,
                          'nome' => 'joão Pessoa Professor Equipe',
                          'agua_escola_id' => 1,
                          'agua_equipe_id' => 1,
                          'created' => null,
                          'modified' => null

                         )
                    ),
                array(
                        'AguaEquipe' => array
                            ( 
                              'id' => 2, 
                              'nome' => 'a pequena',
                              'created' => null, 
                               'modified' => null 
                            )
                        ,
                        'AguaProfessor' => array (
                              'id' => 2,
                              'nome' => 'josé Pessoa Professor Equipe',
                              'agua_escola_id' => 2,
                              'agua_equipe_id' => 2,
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
