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


//essa classe escreve CSS
//TODO implementar as regrinhas doidas. (depois de muito tempo, o Lucas acha que é o esquema de regras específicas dos navegadores)

class TypeDecoratorHelper extends AppHelper
{
	var $mode = 'html_header';  //or 'inline', or 'inline_echo';
	var $active_css_buffer = 'instant.css';
	var $css_buffers = array();
	var $compact = false;

	function sr($match_rule) {return $this->srule($match_rule);}
	function er() {return $this->erule();}
	function r($match_rule, $properties) {return $this->rule($match_rule, $properties);}

/**
 * Contructor
 * 
 * @access public
 * @return void 
 */
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
	
/**
 * Starts one rule declaration
 * 
 * @access public
 * @return void|string One CSS rule or void, {@see self::_return()}
 */
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

/**
 * Ends one rule declaration
 * 
 * @access public
 * @return void|string One CSS rule or void, {@see self::_return()}
 */
	function erule()
	{
		return $this->_return("}\n");
	}
	
/**
 * Constructs the rule body (list of CSS properties)
 * 
 * @access public
 * @return void|string One CSS rule or void, {@see self::_return()}
 */
	function properties($properties)
	{
		$t = '';
		foreach ($properties as $n => $value)
			$t .=  $this->_writeProprety($n, $value);
		
		return $this->_return($t);		
	}
	
/**
 * Constructs one CSS rule
 * 
 * @access public
 * @return void|string One CSS rule or void, {@see self::_return()}
 */
	function rule($match_rule, $properties)
	{
		$mode_backup = $this->mode; //para retornar ao invés de echoar ou colocar na fila
		$this->mode = 'inline';     // ---
		
		$t = $this->srule($match_rule) 
 		   . $this->properties($properties)
		   . $this->erule();
		
		$this->mode = $mode_backup;
		return $this->_return($t);
	}

/**
 * method description
 * 
 * @access public
 * @return string Create the CSS link, or style tag.
 */
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
				$address += array('plugin' => 'typographer','controller' => 'type_stylesheet','action' => 'style');
				$address = Router::url($address);
			}
			
			return "\n" . '<link rel="stylesheet" media="'. $media .'" type="text/css" href="' . $address . '" />';
		}
	}

/**
 * Create an <style> tag for inline code
 * 
 * @access protected
 * @return string Inline CSS code
 */
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

/**
 * Echoes or returns the formated rules depending on $this->mode
 * 
 * @access protected
 * @return void|string The formated rules or void
 */
	protected function _return($r)
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
