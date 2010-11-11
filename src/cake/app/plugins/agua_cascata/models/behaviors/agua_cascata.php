<?php
/**
 * Behavior que vai garantir o cascateamento de afterFind e beforeFind
 */
class AguaCascataBehavior extends ModelBehavior {

    function afterFind(&$Model,$results, $primary)
    {

/*
 *
 * esse trecho resolveria a não chamada do afterFind de um model associado
 *         $count = count($results);

        for ($i = 0; $i < $count; $i++) {
            if (is_array($results[$i])) {
                $classNames = array_keys($results[$i]);
                $count2 = count($classNames);
                for ($j = 0; $j < $count2; $j++) {
                    $className = $classNames[$j];
                    if ($Model->alias != $className) {
                        if (isset($Model->{$className}) && is_object($Model->{$className})) {
                            $data = $Model->{$className}->afterFind(array(array($className => $results[$i][$className])), false);
                        }
                        if (isset($data[0][$className])) {
                            $results[$i][$className] = $data[0][$className];
                        }
                    }
                }
            }
        }

*/

                //tentando inicialmente resolver o problema de dar um trigger nos behavior
        //para as relações hasOne
        foreach ($Model->hasOne as $ModelChild){
            $className = $ModelChild['className'];
            if (isset($Model->{$className}) && is_object($Model->{$className})) {
                $created = FALSE;
                $options = array();
                $params = array();
                //debug($className);
                //debug($Model);
                //
                $results = $Model->{$className}->Behaviors->trigger($Model->{$className}, 'afterFind', array($results,false),array('modParams' => true));
                
            }
        }

  
        return($results);
        //debug($Model);
        //die;
    }

    function beforeFind(&$Model,$query)
    {
        //debug($Model);
        //die;
        return $query;

    }
    
}


?>
