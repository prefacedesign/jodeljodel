<?php

class XmlTagHelper extends AppHelper
{	
	function _juntaAtributos($atr1, $atr2)
	{
		if ($atr1 == null)
			$atr1 = array();
		
		if ($atr2 == null)
			$atr2 = array();
			
		return array_merge_recursive($atr1, $atr2);
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
		return '</'.$tag.'>';
	}
	
	function tag($tag, $atributos = null, $opcoes = null, $conteudo = null)
	{
		//debug($opcoes);
		$opcoes_padrao = array('escape' => false, 'sefecha' => false);
		$opcoes = am($opcoes_padrao, $opcoes);
		//debug($opcoes);
		extract($opcoes);
		unset($opcoes['escape']); // não faz sentido passar adiante
		
		$vazio = $conteudo != '0' ? empty($conteudo) : false;
		
		if ($sefecha || $vazio)
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
		
		if (method_exists($this, 'i' . $n))
		{
			@list($atributos, $opcoes, $conteudo) = $args;
			$opcoes_padrao = array('escape' => false, 'sefecha' => false);
			$opcoes = am($opcoes_padrao, $opcoes);
			extract($opcoes);
			
			$t = $this->{'i' . $n}($atributos, $opcoes);
			
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
				$t .= $conteudo . $this->{'f' . $n}($atributos, $opcoes);
			}
			return $t;
		}
		
		if (preg_match('/(^[if])([A-Za-z]\w*)/', $n, $encontrados))
		{
			$tag = $encontrados[2];
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
		else //if (in_array($n, PedreiroHelper::$tags_automaticas))
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
		
		trigger_error('XmlTag::'.$n.'(): Não exite este método.');
	}
}

?>