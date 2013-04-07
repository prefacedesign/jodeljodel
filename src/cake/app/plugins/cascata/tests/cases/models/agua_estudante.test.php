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
App::import('Model', 'Cascata.AguaEstudante');

class AguaEstudanteTestCase extends CakeTestCase {
    var $fixtures = array(
        'plugin.cascata.agua_estudante',
        'plugin.cascata.agua_professor',
        'plugin.cascata.agua_equipe',
        'plugin.cascata.agua_estudantes_agua_professor'
    );



    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação hasAndBelongsToMany
     * Este ainda não verifica se o Professor dispara o Equipe (já que tem relação belongsTo com ele) - para isso
     * incluir palavra Equipe no nome do professor
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testCascataHasAndBelongsToManyAfterFind()
    {
        $this->AguaEstudante =& ClassRegistry::init('Cascata.AguaEstudante');

        $result = $this->AguaEstudante->pegaTodos();
        $expected = array(
                array(
                        'AguaEstudante' => array
                        (
                            'id' => 1,
                            'nome' => 'maria',
                            'created' => null,
                            'modified' => null
                        ),
                        'AguaProfessor' => array (
                          0 => array (
                              'id' => 1,
                              'nome' => 'joão Pessoa Professor',
                              'agua_escola_id' => 1,
                              'agua_equipe_id' => 1,
                              'created' => null,
                              'modified' => null,
                              'AguaEstudantesAguaProfessor' => array
                                (
                                    'id' => 1,
                                    'agua_estudante_id' => 1,
                                    'agua_professor_id' => 1
                                )
                              ),
                          1 => array (
                              'id' => 2,
                              'nome' => 'josé Pessoa Professor',
                              'agua_escola_id' => 2,
                              'agua_equipe_id' => 2,
                              'created' => null,
                              'modified' => null,
                              'AguaEstudantesAguaProfessor' => array
                                (
                                    'id' => 2,
                                    'agua_estudante_id' => 1,
                                    'agua_professor_id' => 2
                                )
                             )

                          ),
                    ),
                array(
                        'AguaEstudante' => array
                        (
                            'id' => 2,
                            'nome' => 'paula',
                            'created' => null,
                            'modified' => null
                        ),
                        'AguaProfessor' => array (
                          0 => array (
                              'id' => 1,
                              'nome' => 'joão Pessoa Professor',
                              'agua_escola_id' => 1,
                              'agua_equipe_id' => 1,
                              'created' => null,
                              'modified' => null,
                              'AguaEstudantesAguaProfessor' => array
                                (
                                    'id' => 3,
                                    'agua_estudante_id' => 2,
                                    'agua_professor_id' => 1
                                )
                              ),
                          1 => array (
                              'id' => 2,
                              'nome' => 'josé Pessoa Professor',
                              'agua_escola_id' => 2,
                              'agua_equipe_id' => 2,
                              'created' => null,
                              'modified' => null,
                              'AguaEstudantesAguaProfessor' => array
                                (
                                    'id' => 4,
                                    'agua_estudante_id' => 2,
                                    'agua_professor_id' => 2
                                )
                             )

                          ),
                    )
            );


        //fazer teste aqui para verificar se a cadeia veio!
        $this->assertEqual($result,$expected);
    }
}

?>
