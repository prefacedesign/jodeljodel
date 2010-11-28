<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AguaF extends CascataAppModel
{
    var $name = 'AguaF';

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
        //caso seja um sub-vetor
        if (isset($results[0][$this->name][0]['nome']))
                $results[0][$this->name][0]['nome'] .= ' F';
        else
            if (isset($results[0][$this->name]['nome']))
                $results[0][$this->name]['nome'] .= ' F';
            else
                $results[0][$this->name]['nome'] = 'F';
        return $results;
    }



    function getAll()
    {
        return ($this->find('all'));
    }

}

?>
