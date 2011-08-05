<?php

function _fixPath($path)
{
	return dirname($path . '/.'); 
}

class Unit
{
	var $unit_name  = null,
		$round_it   = null,
		$multiplier = null,
		$pixel_multiplier = null; //usado quando estamos também criando imagens a serem usadas em layouts, pois como as imagens não usam CSS, elas


	function __construct($params = null)
	{
		$this->setUnit($params);
	}
	
	/*
		$parametros = array(
			'nome_unidade' => 'px',
			'arredonda' => true,
			'multiplicador' => 1.0,
			'multiplicador_conversor_pixels' => 1.0 --- para o caso de usarmos imagens em outros contextos
		)
	*/
		
	function setUnit ($params = null)
	{
		if (isset($params['unit_name']))
			$this->unit_name = $params['unit_name'];
		else
			$this->unit_name = 'px';
		
		if (isset($params['round_it']))
			$this->round_it = $params['round_it'];
		else
			$this->round_it = true;
			
		if (isset($params['multiplier']))
			$this->multiplier = $params['multiplier'];
		else
			$this->multiplier = 1.0;
		
		if (isset($params['pixel_multiplier']))
			$this->pixel_multiplier = $params['pixel_multiplier'];
		else
			$this->pixel_multiplier = 1.0;
	}
	
	function t($number, $destination = 'css')
	{
		
		$number *= $this->multiplier;
		
		if ($destination == 'image') //temos então que forçosamente converter em pixels, na real estabeleceremos um multiplicador para simplificar por enquanto!
		{
			$number *= $this->pixel_multiplier;
		}
		
		if ($this->round_it)
			$numero = round($number);
		else
			$numero = round($number,2);
		
		//print_r($destino);
		switch ($destination)
		{
			case 'image':
				return $number;
			case 'css':
			default:
				return $number . $this->unit_name;
		}
	}
};

class Grid
{
	var $standard_size;
	
	var $m_size, //tamanho do modulozinho na unidade vigente (todos de baixo são na unidade vigente)
		$M_size, //tamanho do modulozão
		$g_size, //tamanho do intercolúnio
		$M_quantity, //quantidade total de intercolúnios
		$left_gutter, //tamanho da margem esquerda
		$right_gutter,
		$aligment,
		$unit;
	
	
	function __construct($grid_params = null)
	{
		$this->standard_size = array(			
			'M' => 0.0,
			'g' => 0.0,
			'm' => 0.0,
			'u' => 0.0
		);
		
		$standard_grid = array(
			'm_size' => 0,
			'M_size' => 0,  //não tem o i porque ele por padrão é igual ao m
			'M_quantity' => 0,
			'right_gutter' => 0,
			'left_gutter' => 0,
			'aligment' => 'left'
		);
	
		if ($grid_params == null)
		{
			$grid_params = array(); 
		}
		
		$grid_params = array_merge($standard_grid, $grid_params);
		
		if (!isset($grid_params['g_size']))
		{
			$grid_params['g_size'] = $grid_params['m_size'];
		}
		
		$this->m_size = $grid_params['m_size'];
		$this->M_size = $grid_params['M_size'];
		$this->g_size = $grid_params['g_size'];
		$this->M_quantity   = $grid_params['M_quantity'];
		$this->left_gutter  = $grid_params['left_gutter' ];
		$this->right_gutter = $grid_params['right_gutter'];
		$this->alignment    = $grid_params['alignment'];
		$this->unit         = $grid_params['unit'];
	}
	
	//tem o -1.0 como default pois é muito comum que se tenha 10 módulos - 1!
	function size ($size, $write_unit = true)
	{
		if (is_string($size))
			$size = $this->parseToArray($size);
		
		if ($size == null)
		{
			$size = $this->standard_size;
		}
		else
		{
			if ($size == 'A')
			{
				trigger_error('ai');
			}
			$size = array_merge($this->standard_size, $size);
		}

	
		$t =  $size['M'] * $this->M_size
			+ $size['m'] * $this->m_size
			+ $size['g'] * $this->g_size
			+ $size['u'];
		
		
		if ($write_unit)
			$t = $this->unit->t($t);
		
		return $t;
	}
	
	function sizeName($size)
	{
		$t = '';
		if (isset($size['M']) && ($size['M'] != 0))
		{
			$t .= '_' . $size['M'] . 'M';
		}
		
		if (isset($size['m']) && ($size['m'] != 0))
		{
			$t .= '_' . $size['m'] . 'm';
		}
		
		if (isset($size['g']) && ($size['g'] != 0))
		{
			$t .= '_' . $size['g'] . 'g';
		}
		
		if (isset($size['u']) && ($size['u'] != 0))
		{
			$t .= '_' . $size['u'] . 'u';
		}
		
		return $t;
	}

/**
 * Transforms strings like '1M-3g' into array('M' => 1, 'g' => -3).
 * Pparses 'M', 'g', 'm', 'u'
 * 
 * @access public
 * @param string $string The string to parse
 * @return array
 */
	function parseToArray($string = '')
	{
		$array = array();
		foreach (array('M', 'm', 'g', 'u') as $token)
			if (preg_match("/(-?)([0-9]*)$token/", $string, $match))
				$array[$token] = (empty($match[1]) ? 1 : -1) * (empty($match[2]) ? 1 : $match[2]);
		
		return $array;
	}
	
	//@todo Never used function.
	/*
	function calculaTamanhoTotal($poe_unidade = true)
	{
		$t =  $this->M * $this->q
			- 1 * $this->i
			+ $this->m_esquerda + $this->m_direita;
			
		if ($poe_unidade)
			$t = $this->unidade->t($t);
		
		return $t;
	}
	*/
	
};

class Color
{
	public $r = 0;
	public $g = 0;
	public $b = 0;
	
	function __construct ($r = 0, $g = 0, $b = 0)
	{
		$this->setRGB($r, $g, $b);
	}
	
	function setRGB ($r = 0, $g = 0, $b = 0)
	{
		$this->r = max(0, min(255, floor($r)));
		$this->g = max(0, min(255, floor($g)));
		$this->b = max(0, min(255, floor($b)));
		return $this;
	}
	
	function blendWith ($with_color, $opacity = 0.5)
	{
		$this->r = min(255, floor($with_color->r * $opacity + $this->r * (1.0 - $opacity)));
		$this->g = min(255, floor($with_color->g * $opacity + $this->g * (1.0 - $opacity)));
		$this->b = min(255, floor($with_color->b * $opacity + $this->b * (1.0 - $opacity)));
		return $this;
	}
	
	function write ($mode = 'hexa')
	{
		switch($mode)
		{
			case 'rgb':
				return 'RGB(' . $this->r . ',' . $this->g . ',' . $this->b . ')';
			case 'pure_hexa':
				return sprintf("%02x", $this->r) . sprintf("%02x", $this->g) . sprintf("%02x", $this->b);				
			case 'hexa':
			default:
				return '#' . sprintf("%02x", $this->r) . sprintf("%02x", $this->g) . sprintf("%02x", $this->b);
		}
	}
};
/* 
@todo Implement the Font class to work with Fonts

class Fonte
{
*/
	/*Aceita um vetor assim - se não colocarmos algo ele omite!
	array(
		'font-family' => array('Georgia', 'Lucida Sans', ...) ;
		'font-size' => 14px,
		'line-height' => 20px,
		'font-variant' => 'small-caps',
		'font-weight' => 'bold',
		'letter_spacing' => '0.1ex',
		'word_spacing' => '0.2ex',
		'text-decoration' => 'overline',
		'text-transform' => 'uppercase',
		'text-align' => 'justify',
		'text-indent' => '15px',
		'color' => '#fff',
		'background-color' => '#aef'
	);*/
	
	//public $opcoes;
	
	//se no vetor vier ->
	//
	// array(
	//		'fonte_base' =>
	//		...
	// );
	//
	// então ele pega primeiro a fonte base, e depois sobre-escreve por cima
	// com os novos parametros
	/*
	function __construct($ops = null)
	{
	}
	
	function escreveAtributos($quais = 'todos_menos_cores')
	{
	}
	
	// Neste caso a outra sobreescreve a primeira...
	function juntaOutra(&$fonte)
	{
	}
	
	function copiaDeMim()
	{
	}
	
};
*/

/*
function _classe_largura($tamanho, &$grade, $prefixo = 'larg')
{
	$nome_classe = $prefixo . $grade->calcNomeTam($tamanho);
	return '.' . $nome_classe . ' {width: ' . $grade->calcTam($tamanho). ";} \n";
}

function _classe_altura($tamanho, &$grade, $prefixo = 'alt')
{
	$nome_classe = $prefixo . $grade->calcNomeTam($tamanho);
	return '.' . $nome_classe . ' {height: ' . $grade->calcTam($tamanho). ";} \n";
} */

class ImageGenerator
{
	function url($params)
	{
		$url = $this->fileUrl($params);
		$path = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . $url;
		
		if (!file_exists($path))
		{
			if (!$this->generateImageFile($params, $path))
				return 'ERRO na criação da imagem calculada'; //@todo Translate this error message.
		}
		
		$url = str_replace(DS,'/',$url);
		
		return Router::url($url);
	}
	
	function fileUrl($params)
	{
	}
	
	function generateImageFile($params, $url)
	{
	}
};

class CompoundImage extends ImageGenerator
{
	var $dir; // diretorio aonde coloca as imagens com camadas
	var $dir_matrixes; //diretorio aonde se encontram as matrizes
	var $base_name;
	
	/*  @todo Translate this comment.
		$config = array(
			'diretorio_base' => //não precisa, indica o diretorio aonde se encontrarao as copias
			'diretorio_matrizes' => //np, indica o diretorio aonde se encontram as imagens matrizes da imagem composta
		)
	 *
	 */
	
	function __construct($config = null)
	{			
		$this->dir = DS . 'img' . DS . 'derivatives' . DS;
		
		$this->base_name = 'compound_image';

	}
	
	/*** Os exemplo dos parametros estão na função seguinte 
	*/
	//@todo Change the whole naming convention.
	 
	 function fileUrl($params)
	 {
		$name = empty($params['base_name']) ? $base_name : $params['base_name'];
		$ext = isset($params['ext']) ? $params['ext'] : 'png';
	
		$name .= '_w'. $params['w'] . '_h' . $params['h'];
		
		foreach ($params['layers'] as $layer)
		{
			switch ($layer['type'])
			{
				case 'apply_color':
					$name .= sprintf('_ac%02x%02x%02x', $layer['color']->r, $layer['color']->g, $layer['color']->b);
				break;
				case 'image':
					$original_file = str_replace($layer['path'],'.',''); //temos que pegar só o nome do arquivo!
					$tok = strtok($original_file, '/\\'); //take only it's name @todo This is not working properly.
				
					while ($tok !== false)
					{
						$tok = strtok('/\\');						
					}
					$original_file = substr($tok, 0, 4) . substr($tok, -7);
					$name .= sprintf('_i-' . $original_file);
				break;
				case 'tint_image':
					$original_file = str_replace($layer['path'],'.',''); //temos que pegar só o nome do arquivo!
					$tok = strtok($original_file, '/\\');
				
					while ($tok !== false)
					{
						$tok = strtok('/\\');						
					}
					$original_file = substr($tok, 0, 4) . substr($tok, -7);
					$name .= sprintf('_ti-'. sprintf('_ac%02x%02x%02x',$layer['color']->r,$layer['color']->g,$layer['color']->b) .'-' . $original_file);
				break;
			}
		}
		return $url = $this->dir . $name . '.' . $ext;
	 }
	 
	/*** 
	 * $parametros => array(
	 *		'w' => largura,
	 *		'h'	=> altura,
	 *		'camadas' => array(
	 *			array('tipo' => 'aplicar_cor', 'cor' => ),
	 *			array('tipo' => 'imagem', 'caminho' => 'imagem.png'),
	 *			array('tipo' => 'imagem_colorizada', 'caminho' => 'imagem.png', 'cor' => )
	 *       )
	 *		'wi' => largura inicial
	 *		'hi' => altura inicial
	 *      bem simples deve ter algum gerador de nomes também, além disto!
	 */
	
	function generateImageFile($params, $path)
	{
		$ext = isset($params['ext']) ? $params['ext'] : 'png';
		if (isset($params['iw']))
		{
			$w = $params['iw']; //caso não tenha depois vai puxar
			$h = $params['ih'];
			$scale = true;
		}
		else
		{
			$w = $params['w'];
			$h = $params['h'];
			$scale = false;
		}
		
		$img = imagecreatetruecolor($w, $h);
		$img2 = null;
		
		foreach($params['layers'] as $layer)
		{
			switch ($layer['type'])
			{
				case 'apply_color':										
					$x = isset($layer['pos']['x']) ? $layer['pos']['x'] : 0;
					$y = isset($layer['pos']['y']) ? $layer['pos']['y'] : 0;
					$wa = isset($layer['pos']['w']) ? $layer['pos']['w'] : $w - $x;
					$ha = isset($layer['pos']['h']) ? $layer['pos']['h'] : $h - $y;
					
					$color = imagecolorallocate($img, $layer['color']->r, $layer['color']->g, $layer['color']->b);				
					imagefilledrectangle($img, $x, $y, $x + $wa - 1, $y + $ha - 1, $color);
					
				break;
				
				case 'image':
					list($width, $height, $type) = getimagesize(WWW_ROOT . $layer['path']);
					switch($type)
					{
						case IMAGETYPE_JPEG:
							$img2 = imagecreatefromjpeg(WWW_ROOT . $layer['path']);
						break;
						case IMAGETYPE_PNG:
							$img2 = imagecreatefrompng(WWW_ROOT . $layer['path']);
						break;
						case IMAGETYPE_GIF:
							$img2 = imagecreatefromgif(WWW_ROOT . $layer['path']);
						break;
						default:
							trigger_error ('A imagem é de um tipo não suportado -- ImagemComposta::criaArquivo()');
							return false;
					}
					
					// Blending mode is not available when drawing on palette images.
					// @todo Check if it is an palette image (8bit PNG or gif) because it wont work!
					imagealphablending($img, true);		
					imagealphablending($img2, true);
					imagesavealpha($img, true);
					imagecopy($img, $img2, 0, 0, 0, 0,  $w,  $h);
					imagedestroy($img2);
				break;
				
				case 'tint_image':					
					list($width, $height, $type) = getimagesize(WWW_ROOT . $layer['path']);
								
					switch($type)
					{
						case IMAGETYPE_JPEG:
							$img2 = imagecreatefromjpeg(WWW_ROOT . $layer['path']);
						break;
						case IMAGETYPE_PNG:
							$img2 = imagecreatefrompng(WWW_ROOT . $layer['path']);
						break;
						case IMAGETYPE_GIF:
							$img2 = imagecreatefromgif(WWW_ROOT . $layer['path']);
						break;
						default:
							trigger_error ('A imagem é de um tipo não suportado -- ImagemComposta::criaArquivo()');
							return false;
					}

					imagealphablending($img, true);
					imagealphablending($img2, true);
					imagefilter($img2, IMG_FILTER_COLORIZE, $layer['color']->r, $layer['color']->g, $layer['color']->b, 0);
					imagesavealpha($img, true);
					
					$x = isset($layer['pos']['x']) ? $layer['pos']['x'] : 0;
					$y = isset($layer['pos']['y']) ? $layer['pos']['y'] : 0;
					
					imagecopy($img, $img2, $x, $y, 0, 0, imagesx($img2), imagesy($img2));
					
					imagedestroy($img2);
				break;
			}
		}
		
		if ($scale)
		{
			$wf = $params['w'];
			$hf = $params['h'];
			$img2 = imagecreatetruecolor($wf, $hf);
			
			if (!imagecopyresampled($img2, $img, 0, 0, 0, 0, $wf, $hf, $w, $h));
			imagedestroy($img);
			$img = $img2;
		}
		
		switch ($ext)
		{
			case 'jpeg':
			case 'jpg':
				imagejpeg($img, $path, $quality = 90); //@todo Make a parameter and a config option out of this.
			break;
			case 'png':
				imagepng($img, $path, $quality = 8);
			break;
			case 'gif':
				imagegif($img, $path);
			break;
			
			default:
				trigger_error('ImagemComposta::criaArquivo() -- extensão não suportada');
		}
		imagedestroy($img);

		return true;
	}
};





?>