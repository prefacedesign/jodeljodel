<?php

class TypeBricklayerHelper extends AppHelper
{
	static $automatic_tags = array(
		'html','head','title','link','body',
		'h1','h2','h3','h4','div','br','span','hr','img',
		'form', 'input','textarea','p','a','script', 'small',
		'hr','script', 'object', 'param'
	);
	
	static $tags_without_space_after = array(
		'i', 'em', 'span', 'a'
	);
	
	var $helpers = array(
		'Typographer.*TypeStyleFactory' => array(
			'name' => 'TypeStyleFactory'
		)
	);	
	
	function __construct($options)
	{
		parent::__construct($options);
	
		if (isset($options['receive_tools']) && $options['receive_tools'])
		{
			foreach($options['tools'] as $tool_name => $tool)
			{
				$this->{$tool_name} = $tool;
			}
		}
	}
	
	//@todo Find better placement for this funcion.
	function _mergeAttributes($atr1, $atr2)
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
	
	function sboxContainer($attr, $options)
	{
		$own_attr = array(
			'class' => array('box_container')
		);
		
		if (isset($options['size']))
		{
			$this->TypeDecorator->widthGenerateClasses(array(0 => $options['size']));
			$own_attr['class'] = am($own_attr['class'], $this->TypeStyleFactory->widthClassNames($options['size']));
		}
		
		$attr = $this->_mergeAttributes($attr, $own_attr);
		
		unset($options['size']);
		
		return $this->sdiv($attr, $options);
	}
	
	function eboxContainer()
	{
		return $this->ediv();
	}
	
	function sbox($attr, $options)
	{
		$own_attr = array(
			'class' => array('box')
		);
		
		//falta incorporar ainda um monte de opções possíveis para as caixas
		//e ainda um monte de coisas
		
		if (isset($opcoes['size']))
		{
			$this->TypeStyleFactory->widthGenerateClasses(array(0 => $options['size']));
			$own_attr['class'] = am($own_attr['class'], $this->TypeStyleFactory->widthClassNames($options['size']));
		}
		
		$attr = $this->_mergeAttributes($attr, $own_attr);
		
		unset($options['size']);
		
		return $this->sdiv($attr, $options);
	}
	
	function ebox()
	{
		return $this->ediv();
	}
	// This is the old "limpador"
	function floatBreak($attr = array(), $options = null)
	{
		$own_attr = array(
			'class' => array('float_break')
		);
		
		if (isset($options['height']))
		{
			$this->TypeStyleFactory->heightGenerateClasses(array(0 => $options['height']));
			$tmp = $this->TypeStyleFactory->heightClassNames($options['height']);
			$own_attr['class'][] = $tmp[0];
			unset($options['height']);
		}
		
		if (isset($options['width']))
		{
			$this->TypeStyleFactory->widthGenerateClasses(array(0 => $options['width']));
			$tmp = $this->TypeStyleFactory->widthClassNames($options['width']);
			$own_attr['class'][] = $tmp[0];
			unset($options['width']);
		}
		
		$attr = $this->_mergeAttributes($attr, $own_attr);
		
		return $this->div($attr, $options, ' ');
	}
	
	function spara($attr = array(), $options = array())
	{
		$own_attr = array(
			'class' => 'para'
		);
		
		$attr = $this->_mergeAttributes($attr, $own_attr);
	
		return $this->sdiv($attr, $options);
	}

	function epara()
	{
		return $this->ediv();
	}
	
	function para($attr = array(), $options = array(), $paras)
	{
		//para onde passamos os atributos e opcoes passados? -- posso aceitar opcoes individuais, e opcoes generalizadas
		$t = $this->spara($attr, $options);
		
		foreach($paras as $para)
		{
			$t .= $this->sp($attr, $options);
			if (isset($options['escape']) && $options['escape'])
				$t .= $para;
			else
				$t .= h($para);
			$t .= $this->ep();
		}
		
		$t .= $this->epara();
		return $t;
	}
	
	function stag($tag, $attr = null, $options = null)
	{
		$standard_options = array('close_me' => false);
		$options = am($stardard_options, $options);
		extract($options);
		
		// Mount the attribute string
		$attr_string = '';
		
		if(is_array($attr))
		{
			foreach ($attr as $name => $value)
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
				$attr_string .= ' '.$name.'="'.$value.'"';
			}
		}
		return '<' . $tag . $attr_string . ($close_me ? ' /' : '') . '>';
	}

	function etag($tag)
	{
		return '</'.$tag.'>' . (in_array($tag, TypeBricklayer::$tags_without_space_after) ? '' : "\n");
	}
	
	function tag($tag, $attr = null, $options = null, $content = null)
	{
		$standard_options = array('escape' => false, 'close_me' => false);
		$options = am($standard_options, $options);
		extract($options);
		unset($options['escape']); // não faz sentido passar adiante
		
		if ($close_me || empty($content))
		{
			$close_me = true;
			$opcoes['close_me'] = true;
		}
		else
			$close_me = false;
		
		$t = $this->sTag($tag, $attr, $options);
		
		if (!$close_me)
		{
			if (!$escape)
				$content = h($content);
			$t .= $content . $this->eTag($tag);
		}
		
		return $t;
	}
	
	function link($attr = array(), $options = array(), $name = '')
	{
		$attr['href'] = Router::url($options['url']);
		
		return $this->a($attr, $options, $name);
	}
	
	function __call($n, $args)
	{	
		if (substr($n, -3) == 'Dry' || substr($n, -3) == 'Dry')
		{
			$n = substr($n, 0, -3);
			switch(count($args))
			{
				case 1:
					list($content) = $args;
					return $this->{$n}(null, null, $content);
				break;
			
				default:
					return $this->{$n}(null, null);
				break;
			}
		}
		
		if (method_exists($this, 's' . $n))
		{ //@todo Make a class of it
			list($attr, $options, $content) = $args;
			$standard_options = array('escape' => false, 'close_me' => false);
			$options = am($standard_options, $options);
			extract($options);
			
			$t = $this->{'s' . $n}($attr, $options);
			
			if ($close_me || empty($content))
			{
				$close_me = true;
				$options['close_me'] = true;
			}
			else
				$close_me = false;
			
			if (!$close_me)
			{
				if(!$escape)
					$content = h($content);
				$t .= $content . $this->{'e' . $n}($attr, $options);
			}
			return $t;
		}
		
		if (preg_match('/(^[se])([A-Za-z]\w*)/', $n, $matches))
		{
			$tag = $matches[2];
			{
				switch(count($args))
				{
					case 2:
						list($attr, $options) = $args;
						return $this->{$matches[1] . 'tag'}($tag, $attr, $options);
					break;
					
					case 1:
						list($attr) = $args;
						return $this->{$matches[1] . 'tag'}($tag, $attr);
					break;
					
					default:
						return $this->{$matches[1] . 'tag'}($tag);
					break;
				}
			}
		}
		else //@todo Add check: are these permited tags?
		{
			switch(count($args))
			{
				case 3:
					list($attr, $options, $content) = $args;
					return $this->tag($n, $attr, $options, $content);
				break;
				
				case 2:
					list($attr, $options) = $args;
					return $this->tag($n, $attr, $options);
				break;
				
				case 1:
					list($attr) = $args;
					return $this->tag($n, $attr);
				break;
				
				default:
					return $this->tag($n);
				break;
			}
		}
		//@todo Translate this!
		trigger_error('PedreiroHelper::'.$n.'(): Não exite este método.');
	}
}



?>
