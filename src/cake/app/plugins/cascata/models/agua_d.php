<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AguaD extends CascataAppModel
{
    var $name = 'AguaD';

    var $actsAs = array('Cascata.AguaCascata', 'Cascata.AguaY');

    var $belongsTo = array('Cascata.AguaJ');

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
            $results[0][$this->name]['nome'] .= ' D';
        else
            $results[0][$this->name]['nome'] = 'D';
        return $results;
    }

    function getAll()
    {
        return ($this->find('all'));
    }

}


?>
