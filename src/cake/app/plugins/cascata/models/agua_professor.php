<?php
/**
 * Arquivo com Model Professor, utilizado para testar os problemas de cascateamos
 * com afterfind e beforefind
 */
class AguaProfessor extends CascataAppModel
{
    var $name = 'AguaProfessor';

    var $actsAs = array('Cascata.AguaCascata', 'Cascata.AguaPessoa');

    var $belongsTo = array('Cascata.AguaEquipe');

    var $hasAndBelongsToMany = array('Cascata.AguaEstudante');

	
    function afterFind($results, $primary)
    {
        if ($primary)
        {
            foreach ($results as $key => $val)
            {
                $results[$key]['AguaProfessor']['nome'] = $results[$key]['AguaProfessor']['nome'] . " Professor";
            }
            
        }
        return $results;
    }
	

	
    function afterFindCascata($results)
    {
        foreach ($results as $key => $val)
        {
            //caso em que é hasMany, não sei se esse caso eu preciso tratar aqui
            //ou no behaviorCascata
            if (isset($results[$key]['AguaProfessor'][0])){
                foreach ($results[$key]['AguaProfessor'] as $chave_prof => $prof)
                    $results[$key]['AguaProfessor'][$chave_prof]['nome'] = $results[$key]['AguaProfessor'][$chave_prof]['nome'] . " Professor";
            } else
                $results[$key]['AguaProfessor']['nome'] = $results[$key]['AguaProfessor']['nome'] . " Professor";
        }
        
        return $results;
    }
    

    function beforeFind($query)
    {
        $query['conditions'] = array('id = 1');
        return $query;
	}

   function pegaTodos(){
       return $this->find('all');
   }

}


?>
