<?php
class AguaEstudantesController extends AguaCascataAppController {

	var $name = 'AguaEstudantes';

        var $hasAndBelongsToMany = array('AguaCascata.AguaProfessor');

}
?>