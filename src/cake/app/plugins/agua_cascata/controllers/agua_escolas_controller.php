<?php
/**
 * Controller criado para realizar testes que geram não cascateamento
 */
class AguaEscolasController extends AguaCascataAppController {

	var $name = 'AguaEscolas';

        function index(){
            $this->set('escolas', $this->AguaEscola->pegaTodas());
        }

}
?>