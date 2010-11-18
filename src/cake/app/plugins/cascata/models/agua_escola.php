<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AguaEscola extends CascataAppModel
{
    var $name = 'AguaEscola';

    var $hasMany = array('Cascata.AguaProfessor');

    var $actsAs = array('Cascata.AguaCascata');

    function pegaTodas(){
        
        return $this->find('all');
    }
}

?>
