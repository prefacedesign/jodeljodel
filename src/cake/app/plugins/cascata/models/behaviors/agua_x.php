<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AguaXBehavior extends ModelBehavior {
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
            $results[0][$Model->name][0]['nome'] .= ' X';
        else
            if (isset($results[0][$Model->name]['nome']))
                $results[0][$Model->name]['nome'] .= ' X';
            else
                $results[0][$Model->name]['nome'] = 'X';
        return $results;
    }

}


?>
