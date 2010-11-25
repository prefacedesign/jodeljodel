<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AguaJ extends CascataAppModel
{
    var $name = 'AguaJ';
    
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
        if (isset($results[0][$this->name]['nome']))
            $results[0][$this->name]['nome'] .= ' J';
        else
            $results[0][$this->name]['nome'] = 'J';
        return $results;
    }



    function getAll()
    {
        return ($this->find('all'));
    }

}

?>