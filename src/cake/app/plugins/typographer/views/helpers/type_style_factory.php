<?php

class TypeStyleFactoryHelper extends AppHelper
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
	var $helpers = array('Typographer.TypeDecorator');
	
	public static $used_rules = array(); // me refiro a regras de CSS
	
	function __construct($options = null)
	{
		parent::__construct($options);
		
		foreach($options['tools'] as $tool_name => $tool)
		{
			$this->{$tool_name} = $tool;
		}
		
		if (isset($options['register_automatic_classes']) 
			&& $options['register_automatic_classes']
			&& $options['used_automatic_classes'])
		{
			$this->registerAllRules($options['used_automatic_classes']);
		}
	}
	
	
	function widthRuleNames($params)
	{	
		$n = $this->widthClassNames($params);
		return array('width' => '.' . $n[0]);
	}
	
	function widthClassNames($params)
	{
	
		extract($params);
		$t = array('width_');
		
		if (isset($M))
		{	$t[0] .= $this->_writeFraction($M, 3) . 'M';	}
		if (isset($i))
		{ 	$t[0] .= $this->_writeFraction($i, 3) . 'g';	}
		if (isset($m))
		{	$t[0] .= $this->_writeFraction($m, 3) .  'm'; 	}
		if (isset($u))
		{	$t[0] .= $this->_writeFraction($u, 3) . 'u'; 	}
		
		return $t;
	}
	
	function widthRule($params)
	{
		return array(
			'width' => array(
				'w_' => $this->hg->size($params)
			)
		);
	}
	
	function heightRuleNames($params)
	{	
		$n = $this->heightClassNames($params);	
		return array('height' => '.' . $n[0]);
	}
	
	function heightClassNames($params)
	{
		extract($params);
		$t = array('h_');
		
		if (isset($M))
		{	$t[0] .= $this->_writeFraction($M, 3) . 'M';	}
		if (isset($qi))
		{ 	$t[0] .= $this->_writeFraction($g, 3) . 'g';	}
		if (isset($qm))
		{	$t[0] .= $this->_writeFraction($m, 3) .  'm'; 	}
		if (isset($qu))
		{	$t[0] .= $this->_writeFraction($u, 3) . 'u'; 	}
		
		return $t;
	}
	
	function heightRules($params)
	{
		return array(
			'height' => array(
				'height' => $this->vg->size($params)
			)
		);
	}
	
	
	function registerUsedRules($rule_list) // no mesmo formato do vetor
	{
		TypeStyleFactoryHelper::$used_rules = array_merge_recursive(TypeStyleFactoryHelper::$used_rules, $rule_list);
	}
	
	function registerAllRules($params)
	{
		/* Recebe um vetor assim:
			$params = array(
				'width' => muitos arrays de params
				'height' => muitos arrrays de params
				...
			)
		*/
		
		foreach ($params as $type => $some_params)
		{
			$func_name = Inflector::camelize($type);
						
			if (!method_exists($this,'ruleNames'. $func_name))
			{
				//@todo translate this error message
				trigger_error('FabriquinhaHelper::registraTodasAsRegras' . $nome_func . '(): Não foi possível gerar automaticamente este método, porque não existem os métodos de que ele depende.');
				return false;
			}
			
			foreach ($some_params as $par)
			{
				$rule_names = $this->{$func_name .'ruleNames'}($par);
				$this->registerUsedRules($rule_names);
			}
		}
	}
	
	function provideTools(&$tools)
	{
		$this->gh = &$tools['horizontal_grid'];
	}
	
	//function geraClassesXXX($muitos_params, $verifica_se_jah_existe = true)
	
	function __call ($n, $args)
	{
		if(preg_match('/(.+)GenerateClasses/', $n, $matches))
		{
			$type = Inflector::underscore($matches[1]);
			$func_name = $matches[1];
			
			if (!method_exists($this, $func_name .'RuleNames'))
			{
				//@todo Translate this error message
				trigger_error('FabriquinhaHelper::geraClasses' . $nome_func . '(): Não foi possível gerar automaticamente este método, porque não existem os métodos de que ele depende.');
				return false;
			}			
			
			$some_params = $args[0];
			$check_whether_it_already_was_generated = isset($args[1]) ? $args[1] : true;
			$t = '';
			
			foreach ($some_params as $params)
			{
				$rule_name = $this->{$func_name . 'RuleNames'}($params);
				
				if ($check_whether_it_already_was_generated)
				{
					if (isset(TypeStyleFactoryHelper::$used_rules[$type]) && in_array($rule_name, TypeStyleFactoryHelper::$used_rules[$type]))
						continue;
				}
				
				$rules = $this->{$func_name.'Rules'}($params);
				foreach($rules as $type => $rule)
				{
					$t .= $this->TypeDecorator->rule($rule_name[$type],$rule);
				}
				$this->registerUsedRules(array($type => array($rule_name)));
			}
			return $t;
		}
		// @todo Translate this error message.
		trigger_error('FabriquinhaHelper::' . $n . '(): Esta função não existe, meu caro.');
	}
	
	//@todo find better placement for this function, or replace it with PHP one
	function _writeFraction($num, $decimal_places)
	{
		$t = '';
		if ($num == round($num) || $decimal_places <= 0)
		{
			return $t . round($num);
		}
		
		return $t . round($num) . '-'. round(($num - round($num)) * pow(10,$decimal_places));
	}
}



?>
