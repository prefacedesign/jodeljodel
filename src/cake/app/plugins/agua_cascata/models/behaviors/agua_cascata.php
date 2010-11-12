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

    function afterFindCascata(&$Model,$results) {
        //aciona o afterFindCascata do Model filho

        //carregando os filhos do Model
        $filhos = array();
        foreach($Model->hasOne as $filho)
        {
            $filhos[] = $filho['className'];
        }
        foreach($Model->hasMany as $filho)
        {
            $filhos[] = $filho['className'];
        }
        foreach($Model->belongsTo as $filho)
        {
            $filhos[] = $filho['className'];
        }
        foreach($Model->hasAndBelongsToMany as $filho)
        {
            $filhos[] = $filho['className'];
        }

        if (empty($filhos)) {
            return true;
 	}
 	$count = count($filhos);

        $callback = 'afterFindCascata';
        $params = array($results);

        for ($i = 0; $i < $count; $i++)
        {
            $name = $filhos[$i];
            
            //PASSO2: disparar callback dos models filhos
            $result = $Model->{$name}->dispatchMethod($callback, $params);

            if (is_array($result))
            {
                $params[0] = $result;
            }

 	}
        
 	if (isset($params[0]))
        {
            $results = $params[0];
 	}
 	
    }

    function triggerModelCallback(&$Model,$callback,$params,$options)
    {
        $filhos = array();
        foreach($Model->hasOne as $filho)
        {
            $filhos[] = $filho['className'];
        }
        foreach($Model->hasMany as $filho)
        {
            $filhos[] = $filho['className'];
        }
        foreach($Model->belongsTo as $filho)
        {
            $filhos[] = $filho['className'];
        }
        foreach($Model->hasAndBelongsToMany as $filho)
        {
            $filhos[] = $filho['className'];
        }

        if (empty($filhos)) {
            return true;
 	}
 	$options = array_merge(array('break' => false, 'breakOn' => array(null, false), 'modParams' => false), $options);
 	$count = count($filhos);

 	for ($i = 0; $i < $count; $i++)
        {
            $name = $filhos[$i];

            //PASSO1: dar trigger nos behavior
            $result = $Model->{$name}->Behaviors->trigger($Model->{$name}, $callback, $params,$options);

            if (is_array($result))
                $params[0] = $result;


            //PASSO2: disparar callback dos models filhos
            //$result = $Model->{$name}->dispatchMethod($Model->{$name}, $callback, $params);
            $result = $Model->{$name}->dispatchMethod($callback, $params);

            if ($options['modParams'] && is_array($result))
            {
                //TODO: verificar se o params[0] não é sobreposto toda vez, o que deixaria só resultado do último
                $params[0] = $result;
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
