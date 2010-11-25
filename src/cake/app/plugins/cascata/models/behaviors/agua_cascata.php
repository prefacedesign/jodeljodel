<?php
/**
 * Behavior que vai garantir o cascateamento de afterFind e beforeFind
 */
class AguaCascataBehavior extends ModelBehavior {

    function afterFind(&$Model,$results, $primary)
    {
        //aciona o afterFindCascata do Model filho do Model em questão (que vieram nos resultados)
        //ou seja, chamar o triggerModelCallback para cada filho do Model
        //triggerModelCallback(...)
        $results = $this->triggerModelCallback($Model, 'afterFindCascata', array($results,false),array('modParams' => true));

        return($results);
    }

    //TODO: verificar se essa função não desempenha o mesmo código do triggerModelCalback
    //
    //TODO: verificar se  essas duas possibilidades isset($results[0][$filho['className']]) || isset($results[0][$Model->name][$filho['className']])
    //não podem ser tratadas de uma melhor maneira - para não ficar verificando toda hora
    //
    //TODO: verificar se realmente é para disparar os callbacks dos filhos também
    function afterFindCascata(&$Model,$results) {
        //aciona o afterFindCascata do Model filho
        //carregando os filhos do Model
         $filhos = array();
        foreach($Model->hasOne as $filho)
        {
            //só desce nos filhos se estiver nos results
            if(isset($results[0][$filho['className']]) || isset($results[0][$Model->name][$filho['className']]) || ($results[0][$Model->name][0][$filho['className']]))
                $filhos[] = $filho['className'];
        }
        foreach($Model->hasMany as $filho)
        {
            //só desce nos filhos se estiver nos results
            if(isset($results[0][$filho['className']])|| isset($results[0][$Model->name][$filho['className']]) || ($results[0][$Model->name][0][$filho['className']]))
                $filhos[] = $filho['className'];
        }
        foreach($Model->belongsTo as $filho)
        {
            //só desce nos filhos se estiver nos results
            if(isset($results[0][$filho['className']])|| isset($results[0][$Model->name][$filho['className']]) || ($results[0][$Model->name][0][$filho['className']]))
                $filhos[] = $filho['className'];
        }
        foreach($Model->hasAndBelongsToMany as $filho)
        {
            //só desce nos filhos se estiver nos results
            if(isset($results[0][$filho['className']])|| isset($results[0][$Model->name][$filho['className']]) || ($results[0][$Model->name][0][$filho['className']]))
                $filhos[] = $filho['className'];
        }
        
        
        if (empty($filhos)) {
            return true;
 	}

        

 	$count = count($filhos);

        $callback = 'afterFindCascata';
        $params = array($results);

        $count_results = count($results);
        //percorre todos os resultados, precisa dar trriger para cada resultado
	for ($j = 0; $j < $count_results; $j++) {
            if (is_array($params[0][$j])) {
                for ($i = 0; $i < $count; $i++)
                {
                    $name = $filhos[$i];

                    //PASSO1: dar trigger nos behavior dos filhos
                    if (isset($Model->{$name}) && is_object($Model->{$name})) {
                        if (isset($params[0][$j][$name]))
                            $data = $Model->{$name}->Behaviors->trigger($Model->{$name}, $callback, array(array(array($name => $params[0][$j][$name]) ) ),array('modParams' => true));
                        else if (isset($params[0][$j][$Model->name][$name]))
                            $data = $Model->{$name}->Behaviors->trigger($Model->{$name}, $callback, array(array(array($name => $params[0][$j][$Model->name][$name]) ) ),array('modParams' => true));
                            else if (isset($params[0][$j][$Model->name][0][$name])){
                                    $data = $Model->{$name}->Behaviors->trigger($Model->{$name}, $callback, array(array(array($name => $params[0][$j][$Model->name][0][$name]) ) ),array('modParams' => true));
                            }



                    }

                    if (isset($data[0][$name])) {
                            if (isset($params[0][$j][$name]))
                                $params[0][$j][$name] = $data[0][$name];
                            else if (isset($params[0][$j][$Model->name][$name]))
                                    $params[0][$j][$Model->name][$name] = $data[0][$name];
                                    else if (isset($params[0][$j][$Model->name][0][$name]))
                                        $params[0][$j][$Model->name][0][$name] = $data[0][$name];

                    }
                    
                    if (isset($Model->{$name}) && is_object($Model->{$name})) {
                            //disparar callback dos models filhos
                            if (isset($params[0][$j][$name]))
                                $data= $Model->{$name}->dispatchMethod($callback, array(array(array($name => $params[0][$j][$name]) ) ) );
                            else if (isset($params[0][$j][$Model->name][$name]))
                                $data= $Model->{$name}->dispatchMethod($callback, array(array(array($name => $params[0][$j][$Model->name][$name]) ) ) );
                                else if (isset($params[0][$j][$Model->name][0][$name]))
                                $data= $Model->{$name}->dispatchMethod($callback, array(array(array($name => $params[0][$j][$Model->name][0][$name]) ) ) );
                            
                    }
                    if (isset($data[0][$name])) {
                            if (isset($params[0][$j][$name]))
                                $params[0][$j][$name] = $data[0][$name];
                            else if (isset($params[0][$j][$Model->name][$name]))
                                    $params[0][$j][$Model->name][$name] = $data[0][$name];
                                    else if (isset($params[0][$j][$Model->name][0][$name]))
                                        $params[0][$j][$Model->name][0][$name] = $data[0][$name];

                    }

                }
            }
        }

 	if (isset($params[0]))
        {
            if(isset($results[0][$filho['className']]) || isset($results[0][$Model->name][$filho['className']]) || isset($results[0][$Model->name][0][$filho['className']]))
            $results = $params[0];
 	}

        return ($results);
    }

    //TODO: verificar se os filhos não vem num formato diferente (assim como no Cascata.afterFindCascata
    function triggerModelCallback(&$Model,$callback,$params,$options)
    {

        $filhos = array();
        foreach($Model->hasOne as $filho)
        {
            //só desce nos filhos se estiver nos results
            if(isset($params[0][0][$filho['className']]))
                $filhos[] = $filho['className'];
        }
        foreach($Model->hasMany as $filho)
        {
            //só desce nos filhos se estiver nos results
            if(isset($params[0][0][$filho['className']]))
                $filhos[] = $filho['className'];
        }
        foreach($Model->belongsTo as $filho)
        {
            //só desce nos filhos se estiver nos results
            if(isset($params[0][0][$filho['className']]))
                $filhos[] = $filho['className'];
        }
        foreach($Model->hasAndBelongsToMany as $filho)
        {
            //só desce nos filhos se estiver nos results
            if(isset($params[0][0][$filho['className']]))
                $filhos[] = $filho['className'];
        }
        
        if (empty($filhos)) {
            return true;
 	}

        
 	//$options = array_merge(array('break' => false, 'breakOn' => array(null, false), 'modParams' => true), $options);
 	$count = count($filhos);

        $count_results = count($params[0]);

        //percorre todos os resultados, precisa dar trriger para cada resultado
	for ($j = 0; $j < $count_results; $j++) {
            if (is_array($params[0][$j])) {
                for ($i = 0; $i < $count; $i++)
                {
                    $name = $filhos[$i];

                    //PASSO1: dar trigger nos behavior dos filhos
                    if (isset($Model->{$name}) && is_object($Model->{$name})) {
                        $data = $Model->{$name}->Behaviors->trigger($Model->{$name}, $callback, array(array(array($name => $params[0][$j][$name]) ) ),$options);
                    }

                    if (isset($data[0][$name])) {
                            $params[0][$j][$name] = $data[0][$name];
                    }


                    if (isset($Model->{$name}) && is_object($Model->{$name})) {
                            //PASSO2: disparar callback dos models filhos
                            $data= $Model->{$name}->dispatchMethod($callback, array(array(array($name => $params[0][$j][$name]) ) ) );
                    }
                    if (isset($data[0][$name])) {
                            $params[0][$j][$name] = $data[0][$name];
                    }

                }
            }
        }
 	if ($options['modParams'] && isset($params[0]))
        {
            return $params[0];
 	}
 	return true;
    }
}


?>
