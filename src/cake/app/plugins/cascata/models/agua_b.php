<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AguaB extends CascataAppModel
{
    var $name = 'AguaB';

    var $actsAs = array('Cascata.AguaCascata');

    var $hasOne = array('Cascata.AguaE');

    var $hasMany = array('Cascata.AguaF');

    var $hasAndBelongsToMany = array('Cascata.AguaG');


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
                $results[0][$this->name][0]['nome'] .= ' B';
        else
            if (isset($results[0][$this->name]['nome']))
                $results[0][$this->name]['nome'] .= ' B';
            else
                $results[0][$this->name]['nome'] = 'B';
        return $results;
    }



    function getAll()
    {
        return ($this->find('all'));
    }

}

?>
