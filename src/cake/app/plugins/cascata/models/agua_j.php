<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AguaJ extends CascataAppModel
{
    var $name = 'AguaJ';
    
    //var $actsAs = array('Cascata.X');

    var $useTable = false;
    
    function afterFind($results, $primary)
    {

        $results['J'] = 1;
        return $results;
    }

    function getAll()
    {
        return ($this->find('all'));
    }

}

?>
