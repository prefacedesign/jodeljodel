<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AguaH extends CascataAppModel
{
    var $name = 'AguaH';

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
