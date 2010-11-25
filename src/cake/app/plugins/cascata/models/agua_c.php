<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AguaC extends CascataAppModel
{
    var $name = 'AguaC';
    
    var $actsAs = array('Cascata.AguaCascata');

    var $hasMany = array('Cascata.AguaH');

    var $hasOne = array('Cascata.AguaI');
    
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
                $results[0][$this->name][0]['nome'] .= ' C';
        else
            if (isset($results[0][$this->name]['nome']))
                $results[0][$this->name]['nome'] .= ' C';
            else
                $results[0][$this->name]['nome'] = 'C';
        return $results;
    }



    function getAll()
    {
        return ($this->find('all'));
    }

}


?>
