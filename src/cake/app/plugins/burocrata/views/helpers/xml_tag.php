<?php
//@todo Make the XMLTag a appart plugin, and inherit the TypeBricklayerHelper from him.
class XmlTagHelper extends AppHelper
{	
	function _mergeAttributes($atr1, $atr2)
	{
		if ($atr1 == null)
			$atr1 = array();
		
		if ($atr2 == null)
			$atr2 = array();
			
		return array_merge_recursive($atr1, $atr2);
	}

	function stag($tag, $atributos = null, $opcoes = null)
	{
		$opcoes_padrao = array('close_me' => false);
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
		return '<' . $tag . $atr . ($close_me ? ' /' : '') . '>';
	}

	function etag($tag)
	{
		return '</'.$tag.'>';
	}
	
	function tag($tag, $atributos = null, $opcoes = null, $conteudo = null)
	{
		//debug($opcoes);
		$opcoes_padrao = array('escape' => false, 'close_me' => false);
		$opcoes = am($opcoes_padrao, $opcoes);
		//debug($opcoes);
		extract($opcoes);
		unset($opcoes['escape']); // não faz sentido passar adiante
		
		$vazio = $conteudo != '0' ? empty($conteudo) : false;
		
		if ($close_me || $vazio)
		{
			$close_me = true;
			$opcoes['close_me'] = true;
		}
		else
			$close_me = false;
		
		$t = $this->stag($tag, $atributos, $opcoes);
		
		if (!$close_me)
		{
			if (!$escape)
				$conteudo = h($conteudo);
			$t .= $conteudo . $this->etag($tag);
		}
		
		return $t;
	}
	
	function __call($n, $args)
	{
		$n_camelo = Inflector::camelize($n);
		
		if (substr($n, -3) == 'Dry')
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
		
		if (method_exists($this, 's' . $n))
		{
			@list($atributos, $opcoes, $conteudo) = $args;
			$opcoes_padrao = array('escape' => false, 'close_me' => false);
			$opcoes = am($opcoes_padrao, $opcoes);
			extract($opcoes);
			
			if ($close_me || empty($conteudo))
			{
				$close_me = true;
				$opcoes['close_me'] = true;
			}
			else
				$close_me = false;

			$t = $this->{'s' . $n}($atributos, $opcoes);
			
			if (!$close_me)
			{
				if(!$escape)
					$conteudo = h($conteudo);
				$t .= $conteudo . $this->{'e' . $n}($atributos, $opcoes);
			}
			return $t;
		}
		
		if (preg_match('/(^[se])([A-Za-z]\w*)/', $n, $encontrados))
		{
			$tag = $encontrados[2];
			{
				switch(count($args))
				{
					case 2:
						list($atributos, $opcoes) = $args;
						return $this->{$encontrados[1] . 'tag'}($tag, $atributos, $opcoes);
					break;
					
					case 1:
						list($atributos) = $args;
						return $this->{$encontrados[1] . 'tag'}($tag, $atributos);
					break;
					
					default:
						return $this->{$encontrados[1] . 'tag'}($tag);
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