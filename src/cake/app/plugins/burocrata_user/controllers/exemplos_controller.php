<?php
class ExemplosController extends BurocrataUserAppController {

	var $name = 'Exemplos';
	var $uses = array('BurocrataUser.Event');
	var $helpers = array('Burocrata.BuroBurocrata');
	
	function index()
	{
		
	}
}
?>