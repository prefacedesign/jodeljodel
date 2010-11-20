<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AguaD extends CascataAppModel
{
    var $name = 'AguaD';
    var $actsAs = array('Cascata.AguaCascata');
    var $belongsTo = array('Cascata.AguaJ');
}


?>
