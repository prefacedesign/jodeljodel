<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AguaEscola extends AguaCascataAppModel
{
    var $name = 'AguaEscola';

    var $hasOne = 'AguaProfessor';

    function pegaTodas(){
        return $this->find('all');
    }
}

?>
