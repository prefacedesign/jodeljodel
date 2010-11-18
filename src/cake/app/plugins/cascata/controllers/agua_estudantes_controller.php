<?php
class AguaEstudantesController extends CascataAppController {

	var $name = 'AguaEstudantes';

        function index(){
            $this->set('estudantes', $this->AguaEstudante->find('all'));
        }

}
?>