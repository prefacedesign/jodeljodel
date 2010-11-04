<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AguaPessoaBehavior extends ModelBehavior {

    function afterFind(&$Model,$results, $primary)
    {
        foreach ($results as $key => $val)
        {
            $results[$key]['AguaProfessor']['nome'] = $results[$key]['AguaProfessor']['nome'] . " Pessoa";
        }
        return $results;
    }

}

?>
