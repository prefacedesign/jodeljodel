<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Carregando o arquivo com as configurações padrões
 */
Configure::load('CorkCorktile.config');
Configure::read('CorkCorktile.type');

class CorkCorktile extends CorktileAppModel
{
	var $primaryKey = 'key';
	var $name = 'CorkCorktile';

}

?>
