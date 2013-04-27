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
App::import('Model', 'Cascata.AguaProfessor');

class AguaProfessorTestCase extends CakeTestCase {
    var $fixtures = array(
        'plugin.cascata.agua_professor',
        'plugin.cascata.agua_equipe'
    );

    /**
     * Função para verificar se o que está declarado no afterFind do model Professor e do behavior Pessoa
     * vem cascateado - considerando a relação belongsTo
     * Esse teste só considera o afterFind, não considera as modificações que deveriam vir pelo beforeFind
     */
    function testCascataBelongsToAfterFind()
    {
        $this->AguaProfessor =& ClassRegistry::init('Cascata.AguaProfessor');

        $result = $this->AguaProfessor->pegaTodos();
        $expected = array(
                array(
                        'AguaProfessor' => array (
                          'id' => 1,
                          'nome' => 'joão Pessoa Professor',
                          'agua_escola_id' => 1,
                          'agua_equipe_id' => 1,
                          'created' => null,
                          'modified' => null

                         ),
                        'AguaEquipe' => array
                        (
                          'id' => 1,
                          'nome' => 'a grande',
                          'created' => null,
                           'modified' => null
                        )
                    ),
                array(
                        'AguaProfessor' => array (
                              'id' => 2,
                              'nome' => 'josé Pessoa Professor',
                              'agua_escola_id' => 2,
                              'agua_equipe_id' => 2,
                              'created' => null,
                              'modified' => null

                         ),
                        'AguaEquipe' => array
                        (
                          'id' => 2,
                          'nome' => 'a pequena',
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
