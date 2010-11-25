<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AguaG extends CascataAppModel
{
    var $name = 'AguaG';
    
    var $actsAs = array('Cascata.AguaX','Cascata.AguaCascata');

    
    function afterFind($results, $primary)
    {
        if ($primary)
            $results = $this->changeName($results);
        return $results;

    }


    function afterFindCascata($results)
    {
        $results = $this->changeName($results);
        return $results;
    }

    function changeName($results)
    {
        //caso seja um sub-vetor
        if (isset($results[0][$this->name][0]['nome']))
                $results[0][$this->name][0]['nome'] .= ' G';
        else
            if (isset($results[0][$this->name]['nome']))
                $results[0][$this->name]['nome'] .= ' G';
            else
                $results[0][$this->name]['nome'] = 'G';
        return $results;
    }



    function getAll()
    {
        return ($this->find('all'));
    }

}


?>
