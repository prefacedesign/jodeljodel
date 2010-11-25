<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AguaA extends CascataAppModel
{
    var $name = 'AguaA';

    var $actsAs = array('Cascata.AguaCascata');

    var $hasMany = array('Cascata.AguaB');

    var $belongsTo = array('Cascata.AguaD');

    var $hasAndBelongsToMany = array('Cascata.AguaC');


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
        if (isset($results[0][$this->name]['nome']))
            $results[0][$this->name]['nome'] .= ' A';
        else
            $results[0][$this->name]['nome'] = 'A';
        return $results;
    }



    function getAll()
    {
        return ($this->find('all'));
    }

    function getAllRecursive2()
    {
        $this->recursive = 2;
        return ($this->find('all'));
    }

}

?>
