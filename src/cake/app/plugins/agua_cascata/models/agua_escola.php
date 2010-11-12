<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AguaEscola extends AguaCascataAppModel
{
    var $name = 'AguaEscola';

    var $hasMany = array('AguaCascata.AguaProfessor');

    //var $actsAs = array('AguaCascata.AguaCascata');

    function pegaTodas(){
        return $this->find('all');
    }
}

?>
