<?php
class AguaEquipesController extends CascataAppController {

	var $name = 'AguaEquipes';
        

        function index(){
            $this->set('equipes', $this->AguaEquipe->pegaTodas());
        }
}
?>