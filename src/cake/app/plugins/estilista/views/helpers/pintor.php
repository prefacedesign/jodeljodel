<?php

//essa classe escreve CSS
//TODO implementar as regrinhas doidas.

class PintorHelper extends AppHelper
{
	var $modo = 'cabecalho_layout';  //ou 'inline', ou 'inline_echo';
	var $qual_css_armazenar = 'inline.css';
	var $css_virtuais_armazenados = array();
	var $compacto = false;

	function iR($regra_de_match) {return $this->iRegra($regra_de_match());}
	function fR() {return $this->fRegra();}	
	function r($regra_de_match, $propriedades) {return $this->regra($regra_de_match, $propriedades);}


	function __construct($opcoes)
	{
		parent::__construct($opcoes);
		
		if (isset($opcoes['recebe_instrumentos']) && $opcoes['recebe_instrumentos'])
		{
			foreach($opcoes['instrumentos'] as $nome_instrumento => $instrumento)
			{
				$this->{$nome_instrumento} = $instrumento;
			}
		}
		
		if (isset($opcoes['modo']))
		{
			$this->modo = $opcoes['modo'];
		}
		
		if (isset($opcoes['qual_css_armazenar']))
		{
			$this->qual_css_armazenar = $opcoes['qual_css_armazenar'];
		}
		
		if (isset($opcoes['compacto']))
		{
			$this->compacto = $opcoes['compacto'];
		}
	}
	
	
	function iRegra($regra_de_match) 
	{
		return $this->_retorna(
			  ($this->compacto ? '' : "\n")
			. $regra_de_match 
			. ($this->compacto ? ' ' : "\n")
			. '{'
			. ($this->compacto ? ' ' : "\n")
		);
	}
	
	function fRegra()
	{
		return $this->_retorna("}\n");
	}
	
	
	function propriedades($propriedades)
	{
		$t = '';
	
		foreach ($propriedades as $n => $valor)
		{
			$t .=  $this->_linhaPropriedade($n, $valor);
		}
		
		return $this->_retorna($t);		
	}
	
	
	function regra($regra_de_match, $propriedades)
	{
		$backup_modo = $this->modo; //para retornar ao invés de echoar ou colocar na fila
		$this->modo = 'inline';     // ---
		
		$t = $this->iRegra($regra_de_match) 
 		   . $this->propriedades($propriedades)
		   . $this->fRegra();
		
		$this->modo = $backup_modo;
		return $this->_retorna($t);
	}
	
	function css($endereco, $inline = false, $media = 'all')
	{
		if ($inline)
		{
			//eventualmente pode receber uma lista de estilos também!
			return $this->_codigoCssInline($this->css_virtuais_armazenados[$endereco], $media);
		}
		else
		{
			if (is_array($endereco))
			{
				if (isset($endereco['plugin']) && $endereco['plugin'] == 'estilista' && $endereco['controller'] == 'estilos')
				{
					$novo_endereco = '/css/' . $endereco['action'];
					if (isset($endereco[0]))
					{
						$novo_endereco .= '-'.$endereco[0];
					}
					if (isset($endereco[1]))
					{
						$novo_endereco .= '-'.$endereco[1];
					}
					
					$novo_endereco .= '.css';
					
					$endereco = Router::url($novo_endereco);
				}
				else
				{
					$endereco = Router::url($endereco);
				}
			}
			
			return "\n" . '<link rel="stylesheet" media="'. $media .'" type="text/css" href="' . $endereco . '" />';
		}
	}
	
	function _codigoCssInline (&$css, $media = 'all')
	{
		return "\n". '<style type="text/css" media="'. $media .'">'."\n". $css . "\n</style>\n";
	}
	
	// dentro deste linhaPropriedade que devem vir os callbacks para usar calculadoras
	// exemplos de calculadoras de estilo
	//
	// g(8M-i+3m) 		-- chama a grade principal
	// gv(4M) 			-- chama a grade vertical
	// g(qual_grade, 8M-i+4m) 
	// c(8M-14u+20el) 	-- usa unidades e a grade mais a entrelinha
	// c(8Mv-14u+20el) 	-- usa a grade vertical
	// u(45) 			-- usa a unidade em vogar
	// fonte(grande) 	-- usa a fonte grande e põe o atributo que está sendo pedido
	// cor(principal)   -- pega uma cor da paleta
	// cor(paleta, principal)
	//					-- pega aquela cor da paleta
	//
	// url('imgcalc(%v)')	-- poe o vetor como parametro de uma função, pode ter alguns mais simples
	//
	// dá para viajar mais por aqui!!
	
	function _linhaPropriedade($nome, $valor)
	{
		return ($this->compacto ? ' ' : "\t")
			   . $nome 
			   . ":" 
			   . $valor 
			   .($this->compacto ? ';' : ";\n");
	}
	
	function _retorna($r)
	{
		switch ($this->modo)
		{
			case 'inline_echo':
				echo $r;
			break;
			
			case 'cabecalho_layout':
				if (!isset($this->css_virtuais_armazenados[$this->qual_css_armazenar]))
					$this->css_virtuais_armazenados[$this->qual_css_armazenar] = '';
				$this->css_virtuais_armazenados[$this->qual_css_armazenar] .= $r;
			break;
		}
		
		return $r;
	}
	
	
}



?>
