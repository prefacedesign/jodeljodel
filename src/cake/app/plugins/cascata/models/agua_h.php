<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AguaH extends CascataAppModel
{
    var $name = 'AguaH';

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
                $results[0][$this->name][0]['nome'] .= ' H';
        else
            if (isset($results[0][$this->name]['nome']))
                $results[0][$this->name]['nome'] .= ' H';
            else
                $results[0][$this->name]['nome'] = 'H';
        return $results;
    }



    function getAll()
    {
        return ($this->find('all'));
    }

}

?>
