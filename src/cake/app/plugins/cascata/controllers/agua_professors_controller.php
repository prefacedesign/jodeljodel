<?php
/**
 * Controller criado para realizar testes que geram não cascateamento
 */

class AguaProfessorsController extends CascataAppController {

	var $name = 'AguaProfessors';
        
        function index()
        {
            $this->set('todos', $this->AguaProfessor->find('all'));

        }

}
?>