<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::import('Model', 'AguaCascata.AguaProfessor');

class AguaProfessorTestCase extends CakeTestCase {

    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação belongsTo
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testCascataBelongsToAfterFind()
    {
        $this->AguaProfessor =& ClassRegistry::init('AguaCascata.AguaProfessor');

        $result = $this->AguaProfessor->pegaTodos();
        $expected = array(
                array(
                        'AguaProfessor' => array (
                          'id' => 1,
                          'nome' => 'joão Equipe Pessoa Professor',
                          'agua_escola_id' => 1,
                          'agua_equipe_id' => 1,
                          'created' => null,
                          'modified' => null

                         )
                    ),
                array(
                        'AguaProfessor' => array (
                              'id' => 2,
                              'nome' => 'josé Equipe Pessoa Professor',
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
