<?php

//essa classe escreve CSS
//TODO implementar as regrinhas doidas.

class TypeDecoratorHelper extends AppHelper
{
	var $mode = 'html_header';  //or 'inline', or 'inline_echo';
	var $active_css_buffer = 'inline.css';
	var $css_buffers = array();
	var $compact = false;

	function sr($match_rule) {return $this->srule($match_rule);}
	function er() {return $this->erule();}
	function r($match_rule, $propreties) {return $this->regra($$match_rule, $propreties);}


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
		
		if (isset($options['mode']))
		{
			$this->mode = $options['mode'];
		}
		
		if (isset($options['css_buffer']))
		{
			$this->active_css_buffer = $options['css_buffer'];
		}
		
		if (isset($options['compact']))
		{
			$this->compact = $options['compact'];
		}
	}
	
	
	function srule($match_rule) 
	{
		return $this->_return(
			  ($this->compact ? '' : "\n")
			. $match_rule 
			. ($this->compact ? ' ' : "\n")
			. '{'
			. ($this->compact ? ' ' : "\n")
		);
	}
	
	function erule()
	{
		return $this->_return("}\n");
	}
	
	
	function propreties($propreties)
	{
		$t = '';
	
		foreach ($propreties as $n => $value)
		{
			$t .=  $this->_writeProprety($n, $value);
		}
		
		return $this->_return($t);		
	}
	
	
	function rule($match_rule, $propreties)
	{
		$mode_backup = $this->mode; //para retornar ao invés de echoar ou colocar na fila
		$this->mode = 'inline';     // ---
		
		$t = $this->srule($match_rule) 
 		   . $this->propreties($propreties)
		   . $this->erule();
		
		$this->mode = $backup_mode;
		return $this->_return($t);
	}
	
	function css($address, $inline = false, $media = 'all')
	{
		if ($inline)
		{
			//eventualmente pode receber uma lista de estilos também!
			return $this->_inlineCssCode($this->css_buffers[$address], $media);
		}
		else
		{
			if (is_array($address))
			{
				if (isset($address['plugin']) && $address['plugin'] == 'typographer' && $adress['controller'] == 'type_stylesheet')
				{
					//@todo If possible use reverse routing for this:
					$new_address = '/css/' . $address['action'];
					if (isset($address[0]))
					{
						$new_address .= '-' . $address[0];
					}
					if (isset($address[1]))
					{
						$new_address .= '-' . $address[1];
					}
					
					$new_adress .= '.css';
					
					$address = Router::url($new_address);
				}
				else
				{
					$address = Router::url($new_address);
				}
			}
			
			return "\n" . '<link rel="stylesheet" media="'. $media .'" type="text/css" href="' . $address . '" />';
		}
	}
	
	function _inlineCssCode (&$css, $media = 'all')
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
	
	function _writeProprety($name, $value)
	{
		return ($this->compact ? ' ' : "\t")
			   . $name 
			   . ":" 
			   . $value 
			   .($this->compact ? ';' : ";\n");
	}
	
	function _return($r)
	{
		switch ($this->mode)
		{
			case 'inline_echo':
				echo $r;
			break;
			
			case 'html_header':
				if (!isset($this->css_buffers[$this->active_css_buffer]))
					$this->css_buffers[$this->active_css_buffer] = '';
				$this->css_buffers[$this->active_css_buffer] .= $r;
			break;
		}
		
		return $r;
	}
	
	
}



?>
