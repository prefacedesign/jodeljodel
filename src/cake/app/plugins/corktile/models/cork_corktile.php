<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Carregando o arquivo com as configurações padrões
 */
Configure::load('Corkcorktile.config');
Configure::read('Corkcorktile.type');

class Corkcorktile extends CorktileAppModel
{
	var $primaryKey = 'key';
	var $name = 'Corkcorktile';

	var $useTable = 'cork_corktiles';

}

?>
