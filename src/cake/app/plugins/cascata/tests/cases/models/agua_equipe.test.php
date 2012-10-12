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
App::import('Model', 'Cascata.AguaEquipe');

class AguaEquipeTestCase extends CakeTestCase {

    var $fixtures = array(
        'plugin.cascata.agua_equipe',
        'plugin.cascata.agua_professor'
    );


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
