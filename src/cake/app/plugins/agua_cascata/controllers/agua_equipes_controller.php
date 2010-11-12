<?php
class AguaEquipesController extends AguaCascataAppController {

	var $name = 'AguaEquipes';
        

        function index(){
            $this->set('equipes', $this->AguaEquipe->pegaTodas());
        }
}
?>