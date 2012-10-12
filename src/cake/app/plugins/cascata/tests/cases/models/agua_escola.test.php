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
App::import('Model', 'Cascata.AguaEscola');

class AguaEscolaTestCase extends CakeTestCase {
    var $fixtures = array(
        'plugin.cascata.agua_escola',
        'plugin.cascata.agua_professor',
        'plugin.cascata.agua_equipe'
    );

    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação HasMany
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testCascataHasManyAfterFind()
    {
        $this->AguaEscola =& ClassRegistry::init('Cascata.AguaEscola');

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
                        'AguaProfessor' => array (
                            0 => array(
                              'id' => 1,
                              'nome' => 'joão Pessoa Professor',
                              'agua_escola_id' => 1,
                              'agua_equipe_id' => 1,
                              'created' => null,
                              'modified' => null
                            )
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
                        'AguaProfessor' => array (
                            0 => array(
                                  'id' => 2,
                                  'nome' => 'josé Pessoa Professor',
                                  'agua_escola_id' => 2,
                                  'agua_equipe_id' => 2,
                                  'created' => null,
                                  'modified' => null
                                )
                         )
                    )
            );

        //fazer teste aqui para verificar se a cadeia veio!
        $this->assertEqual($result,$expected);
    }
}

?>
