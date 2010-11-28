<?php
/* 
 * Classe de teste mais completa
 */
class AguaA extends CascataAppModel
{
    var $name = 'AguaA';

    var $actsAs = array('Cascata.AguaCascata','Containable','Cascata.AguaY');

    var $hasMany = array('Cascata.AguaB');

    var $belongsTo = array('Cascata.AguaD');

    var $hasAndBelongsToMany = array('Cascata.AguaC');

    


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
            $results[0][$this->name]['nome'] .= ' A';
        return $results;
    }



    function getAll()
    {
        return ($this->find('all'));
    }

    function getAllRecursive2()
    {
        $this->recursive = 2;
        return ($this->find('all'));
    }

    function getAllRecursive3()
    {
        $this->recursive = 3;
        return ($this->find('all'));
    }

    function getOnlyA()
    {
        return ($this->find('all',array('contain' => false)));
    }

    function getOnlyAandB()
    {
        return ($this->find('all', array('contain' => 'AguaB') ));
    }

    function getOnlyAandBandG()
    {
        return ($this->find('all', array('contain' => array(
            'AguaB' => array('AguaG') ) ) ));
    }

    function getOnlyAandBwithId()
    {
        return ($this->find('all', array('contain' => array(
            'AguaB' => array ('id')
            )
          )
        )
       );
    }

    function getOnlyAandDandJ()
    {
        return ($this->find('all', array
            (
                'contain' => array
                (
                    'AguaD' => array
                     (
                        'AguaJ' => array
                        (
                            'id'
                         )
                     )
                )
            )
       ));
    }


}

?>
