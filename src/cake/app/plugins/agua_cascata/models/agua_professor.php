<?php
/**
 * Arquivo com Model Professor, utilizado para testar os problemas de cascateamos
 * com afterfind e beforefind
 */
class AguaProfessor extends AguaCascataAppModel
{
    var $name = 'AguaProfessor';

    var $actsAs = array('AguaCascata.AguaCascata','AguaCascata.AguaPessoa');

    //testar depois
    //var $belongsTo = array('AguaCascata.AguaEquipe');


    function afterFind($results, $primary)
    {
        if ($primary)
        {
            foreach ($results as $key => $val)
            {
                $results[$key]['AguaProfessor']['nome'] = $results[$key]['AguaProfessor']['nome'] . " Professor";
            }
            return $results;
        }
    }

    function afterFindCascata($results)
    {
        foreach ($results as $key => $val)
        {
            $results[$key]['AguaProfessor']['nome'] = $results[$key]['AguaProfessor']['nome'] . " Professor";
        }
        
        return $results;
    }
    

/*    function beforeFind($query)
    {
        $query['conditions'] = array('id = 1');
        return $query;
   }*/

   function pegaTodos(){
       return $this->find('all');
   }

}


?>
