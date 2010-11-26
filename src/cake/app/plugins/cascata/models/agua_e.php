<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AguaE extends CascataAppModel
{
    var $name = 'AguaE';
    
    var $actsAs = array('Cascata.AguaCascata','Cascata.AguaX');

    
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
            $results[0][$this->name]['nome'] .= ' E';
        else
            $results[0][$this->name]['nome'] = 'E';
        return $results;
    }



    function getAll()
    {
        return ($this->find('all'));
    }

}

?>
