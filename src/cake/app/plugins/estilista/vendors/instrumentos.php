<?php

function _consertaCaminho($caminho)
{
	return dirname($caminho . '/.'); 
}

class Unidade
{
	var $nome_unidade  = null,
		$arredonda     = null,
		$multiplicador = null,
		$multiplicador_conversor_pixels = null; //usado quando estamos também criando imagens a serem usadas em layouts, pois como as imagens não usam CSS, elas


	function __construct($parametros = null)
	{
		$this->mudaUnidade($parametros);
	}
	
	/*
		$parametros = array(
			'nome_unidade' => 'px',
			'arredonda' => true,
			'multiplicador' => 1.0,
			'multiplicador_conversor_pixels' => 1.0 --- para o caso de usarmos imagens em outros contextos
		)
	*/
		
	function mudaUnidade ($parametros = null)
	{
		if (isset($parametros['nome_unidade']))
			$this->nome_unidade = $parametros['nome_unidade'];
		else
			$this->nome_unidade = 'px';
		
		if (isset($parametros['arredonda']))
			$this->arredonda = $parametros['arredonda'];
		else
			$this->arredonda = true;
			
		if (isset($parametros['multiplicador']))
			$this->multiplicador = $parametros['multiplicador'];
		else
			$this->multiplicador = 1.0;
		
		if (isset($parametros['multiplicador_conversor_pixels']))
			$this->multiplicador_conversor_pixels = $parametros['multiplicador_conversor_pixels'];
		else
			$this->multiplicador_conversor_pixels = 1.0;
	}
	
	function t($numero, $destino = 'css')
	{
		
		$numero *= $this->multiplicador;
		
		if ($destino == 'imagem') //temos então que forçosamente converter em pixels, na real estabeleceremos um multiplicador para simplificar por enquanto!
		{
			$numero *= $this->multiplicador_conversor_pixels;
		}
		
		if ($this->arredonda)
			$numero = round($numero);
		else
			$numero = round($numero,2);
		
		//print_r($destino);
		switch ($destino)
		{
			case 'imagem':
				return $numero;
			case 'css':
			default:
				return $numero . $this->nome_unidade;
		}
	}
};

class Grade
{
	var $tam_padrao;
	
	var $m, //tamanho do modulozinho na unidade vigente (todos de baixo são na unidade vigente)
		$M, //tamanho do modulozão
		$i, //tamanho do intercolúnio
		$q, //quantidade total de intercolúnios
		$m_esquerda, //tamanho da margem esquerda
		$m_direita,
		$alinhamento,
		$unidade;
	
	
	function __construct($param_grade = null)
	{
		$this->tam_padrao = array(			
			'qM' =>  0.0,
			'qi' => -1.0,
			'qm' =>  0.0,
			'adicional_bruto' => 0
		);
		
		$param_grade_padrao = array(
			'm' => 0,
			'M' => 0,  //não tem o i porque ele por padrão é igual ao m
			'q' => 0,
			'm_esquerda' => 0,
			'm_direita' => 0,
			'alinhamento' => 'esquerda'
		);
	
		if ($param_grade == null)
		{
			$param_grade = array(); 
		}
		
		$param_grade = array_merge($param_grade_padrao, $param_grade);
		
		if (!isset($param_grade['i']))
		{
			$param_grade['i'] = $param_grade['m'];
		}
		
		$this->m = $param_grade['m'];
		$this->M = $param_grade['M'];
		$this->i = $param_grade['i'];
		$this->q = $param_grade['q'];
		$this->m_esquerda  = $param_grade['m_esquerda' ];
		$this->m_direita   = $param_grade['m_direita'  ];
		$this->alinhamento = $param_grade['alinhamento'];
		$this->unidade     = $param_grade['unidade'];
	}
	
	//tem o -1.0 como default pois é muito comum que se tenha 10 módulos - 1!
	function calcTam ($tamanho, $poe_unidade = true)
	{
		if ($tamanho == null)
		{
			$tamanho = $this->tam_padrao;
		}
		else
		{
			$tamanho = array_merge($this->tam_padrao, $tamanho);
		}

	
		$t =  $tamanho['qM'] * $this->M
			+ $tamanho['qm'] * $this->m
			+ $tamanho['qi'] * $this->i;
		
		
		if ($poe_unidade)
			$t = $this->unidade->t($t);
		
		return $t;
	}
	
	function calcNomeTam($tamanho)
	{
		$t = '';
		if (isset($tamanho['qM']) && ($tamanho['qM'] != 0))
		{
			$t .= '_' . $tamanho['qM'] . 'M';
		}
		
		if (isset($tamanho['qm']) && ($tamanho['qm'] != 0))
		{
			$t .= '_' . $tamanho['qm'] . 'm';
		}
		
		if (isset($tamanho['qi']) && ($tamanho['qi'] != 0))
		{
			$t .= '_' . $tamanho['qi'] . 'i';
		}
		
		return $t;
	}
	
	function calculaTamanhoTotal($poe_unidade = true)
	{
		$t =  $this->M * $this->q
			- 1 * $this->i
			+ $this->m_esquerda + $this->m_direita;
			
		if ($poe_unidade)
			$t = $this->unidade->t($t);
		
		return $t;
	}
	
};

class Cor
{
	public $r = 0;
	public $g = 0;
	public $b = 0;
	
	function __construct ($vermelho = 0, $verde = 0, $azul = 0)
	{
		$this->mudaCor($vermelho, $verde, $azul);
	}
	
	function mudaCor ($vermelho = 0, $verde = 0, $azul = 0)
	{
		$this->r = max(0, min(255, floor($vermelho)));
		$this->g = max(0, min(255, floor($verde)));
		$this->b = max(0, min(255, floor($azul)));
	}
	
	function misturaCor ($cor_nova, $opacidade_da_cor_nova = 0.5)
	{
		$this->r = min(255, floor($cor_nova->r * $opacidade_da_cor_nova + $this->r * (1.0 - $opacidade_da_cor_nova)));
		$this->g = min(255, floor($cor_nova->g * $opacidade_da_cor_nova + $this->g * (1.0 - $opacidade_da_cor_nova)));
		$this->b = min(255, floor($cor_nova->b * $opacidade_da_cor_nova + $this->b * (1.0 - $opacidade_da_cor_nova)));
	}
	
	function escreveCor ($modo = 'hexa')
	{
		switch($modo)
		{
			case 'rgb':
				return 'RGB(' . $this->r . ',' . $this->g . ',' . $this->b . ')';
			case 'hexa_puro':
				return sprintf("%02x", $this->r) . sprintf("%02x", $this->g) . sprintf("%02x", $this->b);				
			case 'hexa':
			default:
				return '#' . sprintf("%02x", $this->r) . sprintf("%02x", $this->g) . sprintf("%02x", $this->b);
		}
	}
};

class Fonte
{
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
	
	public $opcoes;
	
	//se no vetor vier ->
	//
	// array(
	//		'fonte_base' =>
	//		...
	// );
	//
	// então ele pega primeiro a fonte base, e depois sobre-escreve por cima
	// com os novos parametros
	
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

class ImagemCalculada
{
	function url($parametros)
	{
		$url = $this->urlArquivo($parametros);
		$caminho = _consertaCaminho(WWW_ROOT . DS . $url);
		
		if (!file_exists($caminho))
		{
			if (!$this->criaArquivo($parametros, $caminho))
				return 'ERRO na criação da imagem calculada';
		}
		
		$url = str_replace(DS,'/',$url);
		
		return Router::url($url);
	}
	
	function urlArquivo($parametros)
	{
	}
	
	function criaArquivo($parametros, $url)
	{
	}
};

class ImagemComposta extends ImagemCalculada
{
	var $dir; // diretorio aonde coloca as imagens com camadas
	var $dir_matrizes; //diretorio aonde se encontram as matrizes
	var $nome_base;
	
	/*  $config = array(
			'diretorio_base' => //não precisa, indica o diretorio aonde se encontrarao as copias
			'diretorio_matrizes' => //np, indica o diretorio aonde se encontram as imagens matrizes da imagem composta
		)
	 *
	 */
	
	function __construct($config = null)
	{			
		$this->dir = DS . 'img' . DS . 'variantes' . DS;
		
		$this->nome_base = 'img_composta';

	}
	
	/*** Os exemplo dos parametros estão na função seguinte 
	*/
	 
	 function urlArquivo($parametros)
	 {
		$nome = empty($parametros['nome_base']) ? $nome_base : $parametros['nome_base'];
		$extensao = isset($parametros['extensao']) ? $parametros['extensao'] : 'png';
	
		$nome .= '_w'. $parametros['w'] . '_h' . $parametros['h'];
		
		foreach ($parametros['camadas'] as $camada)
		{
			switch ($camada['tipo'])
			{
				case 'aplicar_cor':
					$nome .= sprintf('_ac%02x%02x%02x',$camada['cor']->r,$camada['cor']->g,$camada['cor']->b);
				break;
				case 'imagem':
					$arquivo_pego = str_replace($camada['caminho'],'.',''); //temos que pegar só o nome do arquivo!
					$tok = strtok($arquivo_pego, '/\\');
				
					while ($tok !== false)
					{
						$tok = strtok('/\\');						
					}
					$arquivo_pego = substr($tok, 0, 4) . substr($tok, -7);
					$nome .= sprintf('_i-' . $arquivo_pego);
				break;
				case 'imagem_colorizada':
					$arquivo_pego = str_replace($camada['caminho'],'.',''); //temos que pegar só o nome do arquivo!
					$tok = strtok($arquivo_pego, '/\\');
				
					while ($tok !== false)
					{
						$tok = strtok('/\\');						
					}
					$arquivo_pego = substr($tok, 0, 4) . substr($tok, -7);
					$nome .= sprintf('_ic-'. sprintf('_ac%02x%02x%02x',$camada['cor']->r,$camada['cor']->g,$camada['cor']->b) .'-' . $arquivo_pego);
				break;
			}
		}
		return $url = $this->dir . $nome . '.' . $extensao;
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
	
	function criaArquivo($parametros, $caminho)
	{
		$extensao = isset($parametros['extensao']) ? $parametros['extensao'] : 'png';
		if (isset($parametros['wi']))
		{
			$w = $parametros['wi']; //caso não tenha depois vai puxar
			$h = $parametros['hi'];
			$escala = true;
		}
		else
		{
			$w = $parametros['w'];
			$h = $parametros['h'];
			$escala = false;
		}
		
		$img = imagecreatetruecolor($w, $h);
		$img2 = null;
		
		foreach($parametros['camadas'] as $camada)
		{
			switch ($camada['tipo'])
			{
				case 'aplicar_cor':										
					$x = isset($camada['posicao']['x']) ? $camada['posicao']['x'] : 0;
					$y = isset($camada['posicao']['y']) ? $camada['posicao']['y'] : 0;
					$wa = isset($camada['posicao']['w']) ? $camada['posicao']['w'] : $w - $x;
					$ha = isset($camada['posicao']['h']) ? $camada['posicao']['h'] : $h - $y;
					
					$cor = imagecolorallocate($img, $camada['cor']->r, $camada['cor']->g, $camada['cor']->b);				
					imagefilledrectangle($img, $x, $y, $x + $wa - 1, $y + $ha - 1, $cor);
					
				break;
				
				case 'imagem':
					list($width, $height, $type) = getimagesize(WWW_ROOT . $camada['caminho']);
								
					switch($type)
					{
						case IMAGETYPE_JPEG:
							$img2 = imagecreatefromjpeg(WWW_ROOT . $camada['caminho']);
						break;
						case IMAGETYPE_PNG:
							$img2 = imagecreatefrompng(WWW_ROOT . $camada['caminho']);
						break;
						case IMAGETYPE_GIF:
							$img2 = imagecreatefromgif(WWW_ROOT . $camada['caminho']);
						break;
						default:
							trigger_error ('A imagem é de um tipo não suportado -- ImagemComposta::criaArquivo()');
							return false;
					}
					
					imagealphablending($img, true);		
					imagealphablending($img2, true);
					imagesavealpha($img, true);
		
					imagecopy($img, $img2, 0, 0, 0, 0,  $w,  $h);
					imagedestroy($img2);
				break;
				
				case 'imagem_colorizada':					
					list($width, $height, $type) = getimagesize(WWW_ROOT . $camada['caminho']);
								
					switch($type)
					{
						case IMAGETYPE_JPEG:
							$img2 = imagecreatefromjpeg(WWW_ROOT . $camada['caminho']);
						break;
						case IMAGETYPE_PNG:
							$img2 = imagecreatefrompng(WWW_ROOT . $camada['caminho']);
						break;
						case IMAGETYPE_GIF:
							$img2 = imagecreatefromgif(WWW_ROOT . $camada['caminho']);
						break;
						default:
							trigger_error ('A imagem é de um tipo não suportado -- ImagemComposta::criaArquivo()');
							return false;
					}
					
					imagealphablending($img, true);
					imagealphablending($img2, true);
					imagefilter($img2, IMG_FILTER_COLORIZE, $camada['cor']->r, $camada['cor']->g, $camada['cor']->b, 0);
					imagesavealpha($img, true);
					
					$x = isset($camada['posicao']['x']) ? $camada['posicao']['x'] : 0;
					$y = isset($camada['posicao']['y']) ? $camada['posicao']['y'] : 0;
					// Aqui a aplicação do W é mais complicada!
					//$wa = isset($camada['posicao']['w']) ? $camada['posicao']['w'] : $w - $x;
					//$ha = isset($camada['posicao']['h']) ? $camada['posicao']['h'] : $h - $y;
					
					imagecopy($img, $img2, $x, $y, 0, 0, imagesx($img2), imagesy($img2));
					imagedestroy($img2);
				break;
			}
		}
		
		if ($escala)
		{
			$wf = $parametros['w'];
			$hf = $parametros['h'];
			$img2 = imagecreatetruecolor($wf, $hf);
			
			if (!imagecopyresampled($img2, $img, 0, 0, 0, 0, $wf, $hf, $w, $h));
			imagedestroy($img);
			$img = $img2;
		}
		
		switch ($extensao)
		{
			case 'jpeg':
			case 'jpg':
				imagejpeg($img, $caminho, $quality = 90);
			break;
			case 'png':
				imagepng($img, $caminho, $quality = 8);
			break;
			case 'gif':
				imagegif($img, $caminho);
			break;
			
			default:
				trigger_error('ImagemComposta::criaArquivo() -- extensão não suportada');
		}
		imagedestroy($img);

		return true;
	}
};





?>