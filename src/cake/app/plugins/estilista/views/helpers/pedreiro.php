<?php

class PedreiroHelper extends AppHelper
{
	static $tags_automaticas = array(
		'html','head','title','link','body',
		'h1','h2','h3','h4','div','br','span','hr','img',
		'form', 'input','textarea','p','a','script', 'small',
		'hr','script', 'object', 'param'
	);
	
	static $tags_sem_espaco_depois = array(
		'i', 'em', 'span', 'a'
	);
	
	var $helpers = array(
		'Estilista.*Fabriquinha' => array(
			'nome' => 'Fabriquinha'
		)
	);	
	
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
	}
	
	function _juntaAtributos($atr1, $atr2)
	{
		if ($atr1 == null)
			$atr1 = array();
		
		if ($atr2 == null)
			$atr2 = array();
			
		return array_merge_recursive($atr1, $atr2);
	}
	
	/* $opcoes = array(
			'tam' => tamanho de grade
	 */
	
	function iCaixote($atributos, $opcoes)
	{
		$atributos_proprios = array(
			'class' => array('caixote')
		);
		
		if (isset($opcoes['tam']))
		{
			$this->Fabriquinha->geraClassesLargura(array(0 => $opcoes['tam']));
			$atributos_proprios['class'] = am($atributos_proprios['class'], $this->Fabriquinha->nomesClassesLargura($opcoes['tam']));
		}
		
		$atributos = $this->_juntaAtributos($atributos, $atributos_proprios);
		
		unset($opcoes['tam']);
		
		return $this->iDiv($atributos, $opcoes);
	}
	
	function fCaixote()
	{
		return $this->fDiv();
	}
	
	function iCaixa($atributos, $opcoes)
	{
		$atributos_proprios = array(
			'class' => array('caixa')
		);
		
		//falta incorporar ainda um monte de opções possíveis para as caixas
		//e ainda um monte de coisas
		
		if (isset($opcoes['tam']))
		{
			$this->Fabriquinha->geraClassesLargura(array(0 => $opcoes['tam']));
			$atributos_proprios['class'] = am($atributos_proprios['class'], $this->Fabriquinha->nomesClassesLargura($opcoes['tam']));
		}
		
		$atributos = $this->_juntaAtributos($atributos, $atributos_proprios);
		
		unset($opcoes['tam']);
		
		return $this->iDiv($atributos, $opcoes);
	}
	
	function fCaixa()
	{
		return $this->fDiv();
	}
	
	function limpador($atributos = array(), $opcoes = null)
	{
		$atributos_proprios = array(
			'class' => array('limpador')
		);
		
		if (isset($opcoes['altura']))
		{
			$this->Fabriquinha->geraClassesAltura(array(0 => $opcoes['altura']));
			$tmp = $this->Fabriquinha->nomesClassesAltura($opcoes['altura']);
			$atributos_proprios['class'][] = $tmp[0];
			unset($opcoes['altura']);
		}
		
		if (isset($opcoes['largura']))
		{
			$this->Fabriquinha->geraClassesLargura(array(0 => $opcoes['largura']));
			$tmp = $this->Fabriquinha->nomesClassesLargura($opcoes['largura']);
			$atributos_proprios['class'][] = $tmp[0];
			unset($opcoes['largura']);
		}
		
		$atributos = $this->_juntaAtributos($atributos, $atributos_proprios);
		
		return $this->div($atributos, $opcoes, ' ');
	}
	
	function iParagrafos($atributos = array(), $opcoes = array())
	{
		$atributos_proprios = array(
			'class' => 'paragrafos'
		);
		
		$atributos = $this->_juntaAtributos($atributos, $atributos_proprios);
	
		return $this->iDiv($atributos, $opcoes);
	}

	function fParagrafos()
	{
		return $this-> fDiv();
	}
	
	function paragrafos($atributos = array(), $opcoes = array(), $paragrafos)
	{
		//para onde passamos os atributos e opcoes passados? -- posso aceitar opcoes individuais, e opcoes generalizadas
		$t = $this->iParagrafos($atributos, $opcoes);
		
		foreach($paragrafos as $paragrafo)
		{
			$t .= $this->iP($atributos, $opcoes);
			if (isset($opcoes['escape']) && $opcoes['escape'])
				$t .= $paragrafo;
			else
				$t .= h($paragrafo);
			$t .= $this->fP();
		}
		
		$t .= $this->fParagrafos();
		return $t;
	}
	
	function iTag($tag, $atributos = null, $opcoes = null)
	{
		$opcoes_padrao = array('sefecha' => false);
		$opcoes = am($opcoes_padrao, $opcoes);
		extract($opcoes);
		
		$atr = '';
		
		if(is_array($atributos))
		{
			foreach ($atributos as $name => $value)
			{
				if(is_array($value))
				{
					switch($name)
					{
						case 'class':	
							$value = implode(' ', $value);
						break;
					}
				}
				$atr .= ' '.$name.'="'.$value.'"';
			}
		}
		return '<' . $tag . $atr . ($sefecha ? ' /' : '') . '>';
	}

	function fTag($tag)
	{
		return '</'.$tag.'>' . (in_array($tag, PedreiroHelper::$tags_sem_espaco_depois) ? '' : "\n");
	}
	
	function tag($tag, $atributos = null, $opcoes = null, $conteudo = null)
	{
		//debug($opcoes);
		$opcoes_padrao = array('escape' => false, 'sefecha' => false);
		$opcoes = am($opcoes_padrao, $opcoes);
		//debug($opcoes);
		extract($opcoes);
		unset($opcoes['escape']); // não faz sentido passar adiante
		
		if ($sefecha || empty($conteudo))
		{
			$sefecha = true;
			$opcoes['sefecha'] = true;
		}
		else
			$sefecha = false;
		
		$t = $this->iTag($tag, $atributos, $opcoes);
		
		if (!$sefecha)
		{
			if (!$escape)
				$conteudo = h($conteudo);
			$t .= $conteudo . $this->fTag($tag);
		}
		
		return $t;
	}
	
	function linque($atributos = array(), $opcoes = array(), $nome = '')
	{
		$atributos['href'] = Router::url($opcoes['url']);
		
		return $this->a($atributos, $opcoes, $nome);
	}
	
	function __call($n, $args)
	{	
		$n_camelo = Inflector::camelize($n);
		
		if (substr($n, -4) == 'Seco' || substr($n, -4) == 'Seca')
		{
			$n = substr($n, 0, -4);
			switch(count($args))
			{
				case 1:
					list($conteudo) = $args;
					return $this->{$n}(null, null, $conteudo);
				break;
			
				default:
					return $this->{$n}(null, null);
				break;
			}
		}
		
		if (method_exists($this, 'i' . $n_camelo))
		{
			list($atributos, $opcoes, $conteudo) = $args;
			$opcoes_padrao = array('escape' => false, 'sefecha' => false);
			$opcoes = am($opcoes_padrao, $opcoes);
			extract($opcoes);
			
			$t = $this->{'i' . $n_camelo}($atributos, $opcoes);
			
			if ($sefecha || empty($conteudo))
			{
				$sefecha = true;
				$opcoes['sefecha'] = true;
			}
			else
				$sefecha = false;
			
			if (!$sefecha)
			{
				if(!$escape)
					$conteudo = h($conteudo);
				$t .= $conteudo . $this->{'f' . $n_camelo}($atributos, $opcoes);
			}
			return $t;
		}
		
		if (preg_match('/([if])([A-Z]\w*)/', $n, $encontrados))
		{
			$tag = low($encontrados[2]);
			if(in_array($tag, PedreiroHelper::$tags_automaticas))
			{
				switch(count($args))
				{
					case 2:
						list($atributos, $opcoes) = $args;
						return $this->{$encontrados[1] . 'Tag'}($tag, $atributos, $opcoes);
					break;
					
					case 1:
						list($atributos) = $args;
						return $this->{$encontrados[1] . 'Tag'}($tag, $atributos);
					break;
					
					default:
						return $this->{$encontrados[1] . 'Tag'}($tag);
					break;
				}
			}
		}
		else if (in_array($n, PedreiroHelper::$tags_automaticas))
		{
			switch(count($args))
			{
				case 3:
					list($atributos, $opcoes, $conteudo) = $args;
					return $this->tag($n, $atributos, $opcoes, $conteudo);
				break;
				
				case 2:
					list($atributos, $opcoes) = $args;
					return $this->tag($n, $atributos, $opcoes);
				break;
				
				case 1:
					list($atributos) = $args;
					return $this->tag($n, $atributos);
				break;
				
				default:
					return $this->tag($n);
				break;
			}
		}
		
		trigger_error('PedreiroHelper::'.$n.'(): Não exite este método.');
	}
}



?>
