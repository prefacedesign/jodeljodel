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

class AguaYBehavior extends ModelBehavior {
    function afterFind(&$Model,$results, $primary)
    {
        if ($primary)
            $results = $this->changeName($Model, $results);
        return $results;

    }

    function afterFindCascata(&$Model,$results)
    {
        $results = $this->changeName($Model,$results);
        return $results;
    }

    function changeName(&$Model,$results)
    {
        if (isset($results[0][$Model->name][0]['nome']))
            $results[0][$Model->name][0]['nome'] .= ' Y';
        else
            if (isset($results[0][$Model->name]['nome']))
                $results[0][$Model->name]['nome'] .= ' Y';
            else
                $results[0][$Model->name]['nome'] = 'Y';
        return $results;
    }

}


?>
