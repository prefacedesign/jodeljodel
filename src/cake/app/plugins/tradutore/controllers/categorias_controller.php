<?php
class CategoriasController extends AppController 
{
	var $name = 'Categorias';
	var $uses = array('Tradutore.Categoria');
	var $components = array('Tradutore.TradLanguageSelector');
	
	function index()
	{
		debug('teste');
		die;
	}
}
?>