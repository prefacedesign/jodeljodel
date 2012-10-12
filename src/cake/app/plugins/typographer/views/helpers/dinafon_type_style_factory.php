<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */


App::import('Helper', 'Typographer.TypeStyleFactory');

class DinafonTypeStyleFactoryHelper extends TypeStyleFactoryHelper
{

	/*
		$Params = array(
			'h1','h2','width'
		)
	 */
	 
	function topoCaixaRuleNames($params)
	{	
		$n = $this->topoCaixaClassNames($params);
		return array('topoCaixa' => '.' . $n[0]);
	}
	
	function topoCaixaClassNames($params)
	{
		extract($params);
		$t = array('w_');
		
		if (isset($width['M']))
		{	$t[0] .= $this->_writeFraction($width['M'], 3) . 'M'; }
		if (isset($width['g']))
		{ 	$t[0] .= $this->_writeFraction($width['g'], 3) . 'g'; }
		if (isset($width['m']))
		{	$t[0] .= $this->_writeFraction($width['m'], 3) . 'm'; }
		if (isset($width['u']))
		{	$t[0] .= $this->_writeFraction($width['u'], 3) . 'u'; }
		
		$t[0] .= '_h1_' . $h1 . '_h2_' . $h2;
		
		return $t;
	}
	
	function topoCaixaRules($params)
	{
		return array(
			'topoCaixa' => array(
				'background-image' => "url('" . $this->imagem_topo_caixas->url(array(
						'largura' => $params['width'],
						'cor_frente' => $this->palette['fundo_caixotinho'],
						'cor_fundo' => $this->palette['fundo_conteudo'],
						'altura1' => $params['h1'],
						'altura2' => $params['h2']
					)) . "')"
				)
		);
	}
}
?>
