<?php
/**
 * Arquivo com Model Professor, utilizado para testar os problemas de cascateamos
 * com afterfind e beforefind
 */
class AguaProfessor extends AguaCascataAppModel
{
    var $name = 'AguaProfessor';

    var $actsAs = array('AguaCascata.AguaPessoa');


    function afterFind($results, $primary)
    {
//        debug($results);
//        die;
        foreach ($results as $key => $val)
        {
            $results[$key]['AguaProfessor']['nome'] = $results[$key]['AguaProfessor']['nome'] . " Professor";
        }
        return $results;
    }

    function beforeFind($query)
    {
        $query['conditions'] = array('id = 1');
        return $query;
   }

}


?>
