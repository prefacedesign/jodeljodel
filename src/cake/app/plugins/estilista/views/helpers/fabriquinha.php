<?php

class FabriquinhaHelper extends AppHelper
{
	/*  Tem a seguinte forma o $classesUsadas
		
		$regras_usadas =	array(
			'tipo_classe' => array(
				0 => 'nome_classe',
				1 => 
				2 =>
			)
		);
	*/
	var $helpers = array('Estilista.Pintor');
	
	public static $regras_usadas = array(); // me refiro a regras de CSS
	
	function __construct($opcoes = null)
	{
		parent::__construct($opcoes);
		
		foreach($opcoes['instrumentos'] as $nome_instrumento => $instrumento)
		{
			$this->{$nome_instrumento} = $instrumento;
		}
		
		if (isset($opcoes['registra_classes_automaticas']) 
			&& $opcoes['registra_classes_automaticas']
			&& $opcoes['classes_automaticas_usadas'])
		{
			$this->registraTodasAsRegras($opcoes['classes_automaticas_usadas']);
		}
	}
	
	
	function nomesRegrasLargura($params)
	{	
		$n = $this->nomesClassesLargura($params);	
		return array('largura' => '.' . $n[0]);
	}
	
	function nomesClassesLargura($params)
	{
	
		extract($params);
		$t = array('larg_');
		
		if (isset($qM))
		{	$t[0] .= $this->_expressaNumeroFracionario($qM, 3) . 'M';	}
		if (isset($qi))
		{ 	$t[0] .= $this->_expressaNumeroFracionario($qi, 3) . 'i';	}
		if (isset($qm))
		{	$t[0] .= $this->_expressaNumeroFracionario($qm, 3) .  'm'; 	}
		if (isset($qu))
		{	$t[0] .= $this->_expressaNumeroFracionario($qu, 3) . 'u'; 	}
		
		return $t;
	}
	
	function regrasLargura($params)
	{
		return array(
			'largura' => array(
				'width' => $this->gh->calcTam($params)
			)
		);
	}
	
	function nomesRegrasAltura($params)
	{	
		$n = $this->nomesClassesAltura($params);	
		return array('altura' => '.' . $n[0]);
	}
	
	function nomesClassesAltura($params)
	{
	
		extract($params);
		$t = array('alt_');
		
		if (isset($qM))
		{	$t[0] .= $this->_expressaNumeroFracionario($qM, 3) . 'M';	}
		if (isset($qi))
		{ 	$t[0] .= $this->_expressaNumeroFracionario($qi, 3) . 'i';	}
		if (isset($qm))
		{	$t[0] .= $this->_expressaNumeroFracionario($qm, 3) .  'm'; 	}
		if (isset($qu))
		{	$t[0] .= $this->_expressaNumeroFracionario($qu, 3) . 'u'; 	}
		
		return $t;
	}
	
	function regrasAltura($params)
	{
		return array(
			'altura' => array(
				'height' => $this->gv->calcTam($params)
			)
		);
	}
	
	
	function registraRegrasUsadas($lista_regras) // no mesmo formato do vetor
	{
		FabriquinhaHelper::$regras_usadas = array_merge_recursive(FabriquinhaHelper::$regras_usadas,$lista_regras);
	}
	
	function registraTodasAsRegras($params)
	{
		/* Recebe um vetor assim:
			$params = array(
				'largura' => muitos arrays de params
				'altura' => muitos arrrays de params
				...
			)
		*/
		
		foreach ($params as $tipo => $muitos_params)
		{
			$nome_func = Inflector::camelize($tipo);
						
			if (!method_exists($this,'nomesRegras'. $nome_func))
			{
				trigger_error('FabriquinhaHelper::registraTodasAsRegras' . $nome_func . '(): Não foi possível gerar automaticamente este método, porque não existem os métodos de que ele depende.');
				return false;
			}
			
			foreach ($muitos_params as $par)
			{
				$nome_regras = $this->{'nomesRegras'.$nome_func}($par);
				$this->registraRegrasUsadas($nome_regras);
			}
		}
	}
	
	function proveInstrumentos(&$instrumentos)
	{
		$this->gh = &$instrumentos['grade_horizontal'];
	}
	
	//function geraClassesXXX($muitos_params, $verifica_se_jah_existe = true)
	
	function __call ($n, $args)
	{
		if(preg_match('/geraClasses(.+)/', $n, $matches))
		{
			$tipo = Inflector::underscore($matches[1]);
			$nome_func = $matches[1];
			
			if (!method_exists($this,'nomesRegras'. $nome_func))
			{
				trigger_error('FabriquinhaHelper::geraClasses' . $nome_func . '(): Não foi possível gerar automaticamente este método, porque não existem os métodos de que ele depende.');
				return false;
			}			
			
			$muitos_params = $args[0];
			$verifica_se_jah_existe = isset($args[1]) ? $args[1] : true;
			$t = '';
			
			foreach ($muitos_params as $params)
			{
				$nome_regra = $this->{'nomesRegras'.$nome_func}($params);
				
				if ($verifica_se_jah_existe)
				{
					if (isset(FabriquinhaHelper::$regras_usadas[$tipo]) && in_array($nome_regra, FabriquinhaHelper::$regras_usadas[$tipo]))
						continue;
				}
				
				$regras = $this->{'regras'.$nome_func}($params);
				foreach($regras as $tipo => $regra)
				{
					$t .= $this->Pintor->regra($nome_regra[$tipo],$regra);
				}
				$this->registraRegrasUsadas(array($tipo => array($nome_regra)));
			}
			return $t;
		}
		trigger_error('FabriquinhaHelper::' . $n . '(): Esta função não existe, meu caro.');
	}
	
	function _expressaNumeroFracionario($num, $casas_decimais)
	{
		$t = '';
		if ($num == round($num) || $casas_decimais <= 0)
		{
			return $t . round($num);
		}
		
		return $t . round($num) . '-'. round(($num - round($num)) * pow(10,$casas_decimais));
	}
}



?>
