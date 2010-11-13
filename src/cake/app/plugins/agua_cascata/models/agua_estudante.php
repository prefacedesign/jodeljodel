<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class AguaEstudante extends AguaCascataAppModel
{
    var $name = 'AguaEstudante';

    var $hasAndBelongsToMany = array('AguaCascata.AguaProfessor' );

    var $actsAs = array('AguaCascata.AguaCascata');

    function pegaTodos()
    {
        return $this->find('all');
    }

/*    function afterFind($results, $primary)
    {
        if ($primary)
        {
            return $results;
        }
    }

    function afterFindCascata($results)
    {
        return $results;
    }*/
}

?>
