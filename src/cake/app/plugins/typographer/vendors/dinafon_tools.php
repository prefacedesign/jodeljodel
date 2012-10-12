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


class ImagemTopoCaixas extends ImageGenerator
{
	var $alturas, $altura_max, $dir, $base_name, $hg, $u, $vg;
	
	function __construct($basedTools)
	{
		$this->hg =& $basedTools['hg'];
		$this->vg =& $basedTools['vg'];
		$this->u  =& $basedTools['u'];
		
		$this->altura_max = $this->u->t($this->hg->size(array('g' => 3/2), false), 'image');
		
		$this->alturas = array(
			0 => ($this->altura_max * 0),
			1 => ($this->altura_max * 1)/5,
			2 => ($this->altura_max * 2)/5,
			3 => ($this->altura_max * 3)/5,
			4 => ($this->altura_max * 4)/5,
			5 => ($this->altura_max * 5)/5
		);
		
		$this->dir = DS . 'img' . DS . 'derivatives' . DS;
		$this->base_name = 'topo_caixa';
	}

	
	/*	$parametros = array(
	 *		'largura' => array(
	 *			'qM' => ...
	 *			'qI' => ...
	 *			etc.
	 *		)
	 *		'cor_frente' => (objeto do tipo cor)
	 *		'cor_fundo'  => (objeto do tipo cor)
	 *		'altura1'    => (algo entre 0 e 5)
	 *		'altura2'   => (algo entre 0 e 5)
	 *	);
	 */
	
	function fileUrl($parametros)
	{
		$largura = $this->u->t($this->hg->size($parametros['largura'], false), 'image');
		
		$url = $this->dir . $this->base_name
					. '_bg-' . $parametros['cor_fundo']->write('pure_hexa') 
					. '_fg-' . $parametros['cor_frente']->write('pure_hexa') 
					. '_w-' .  $largura
					. '_h1-' . str_replace('.','p',$this->alturas[$parametros['altura1']])
					. '_h2-' . str_replace('.','p',$this->alturas[$parametros['altura2']])
					. '.png';
	
		return $url;
	}
	
	function generateImageFile($parametros, $url)
	{	
		if (!defined('MULT'))
			define('MULT', 3); //este é o multiplicador do Antialiasing

		
		//convertendo a largura para pixels:
		$largura = $this->u->t($this->hg->size($parametros['largura']), 'image');
	
		$img  = imagecreatetruecolor($largura * MULT, $this->altura_max * MULT); //esta imagem maior é para ter uma espécie de antialiasing
		$img2 = imagecreatetruecolor($largura, $this->altura_max); 
		
		if (empty($img) || empty($img2))
		{
			imagedestroy($img);
			imagedestroy($img2);
			return false;
		}
			
		$cor_fundo  = imagecolorallocate($img, $parametros['cor_fundo']->r,  $parametros['cor_fundo']->g,  $parametros['cor_fundo']->b);
		$cor_frente = imagecolorallocate($img, $parametros['cor_frente']->r, $parametros['cor_frente']->g, $parametros['cor_frente']->b);			
		
		if (!imagefilledrectangle($img, 0, 0, $largura * MULT - 1, $this->altura_max * MULT - 1, $cor_fundo))
		{
			imagedestroy($img);
			imagedestroy($img2);
			return false;
		}
			
		if (!imagefilledpolygon(
					$img, 
					array(
						0, $this->altura_max * MULT - 1,
						0, $this->altura_max * MULT - 1 - $this->alturas[$parametros['altura1']] * MULT, //as alturas são indexadas
						$largura * MULT - 1, $this->altura_max * MULT - 1 - $this->alturas[$parametros['altura2']] * MULT,
						$largura * MULT - 1, $this->altura_max * MULT - 1
					),
					4,
					$cor_frente
				)
			)
		{
			imagedestroy($img);
			imagedestroy($img2);
			return false;
		}
		
		if (!imagecopyresampled($img2, $img, 0, 0, 0, 0, $largura, $this->altura_max, $largura  * MULT, $this->altura_max  * MULT))
		{
			imagedestroy($img);
			imagedestroy($img2);
			return false;
		}
		
		if (!imagepng($img2, $url, $quality = 7))
		{
			imagedestroy($img);
			imagedestroy($img2);
			return false;
		}
		
		imagedestroy($img);
		imagedestroy($img2);
		return true;
	}
};






?>