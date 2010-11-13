<?php
class AguaEstudantesController extends AguaCascataAppController {

	var $name = 'AguaEstudantes';

        function index(){
            $this->set('estudantes', $this->AguaEstudante->find('all'));
        }

}
?>