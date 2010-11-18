<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AguaXBehavior extends ModelBehavior {
    function afterFind(&$Model,$results, $primary)
    {
        if ($primary) {
            foreach ($results as $key => $val)
            {
                if (isset($results[$key][$Model->name]['nome']))
                        $results[$key][$Model->name]['nome'] .= ' X';
            }

        }
        return $results;
    }
}


?>
