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

class AguaPessoaBehavior extends ModelBehavior {

    

    function afterFind(&$Model,$results, $primary)
    {
        if ($primary) {
            //TODO: verificar se precisa colocar if $primary
            foreach ($results as $key => $val)
            {
                $results[$key]['AguaProfessor']['nome'] = $results[$key]['AguaProfessor']['nome'] . " Pessoa";
            }
        }
        return $results;
    }

    function afterFindCascata(&$Model, $results)
    {
        //TODO: verificar se precisa de mais parametros no afterFindCascata
        foreach ($results as $key => $val)
        {
            //caso em que é hasMany, não sei se esse caso eu preciso tratar aqui
            //ou no behaviorCascata
            if (isset($results[$key]['AguaProfessor'][0])){
                foreach ($results[$key]['AguaProfessor'] as $chave_prof => $prof)
                    $results[$key]['AguaProfessor'][$chave_prof]['nome'] = $results[$key]['AguaProfessor'][$chave_prof]['nome'] . " Pessoa";
            } else
                $results[$key]['AguaProfessor']['nome'] = $results[$key]['AguaProfessor']['nome'] . " Pessoa";
        }
        return $results;
    }

}

?>
