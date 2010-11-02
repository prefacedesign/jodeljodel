<?php

//cria os aliases para os helpers -- e trata os helpers com o coringa '*'

class EstilistaView extends View
{
	function &_loadHelpers(&$loaded, $helpers, $parent = null) 
	{		
		$modelo = $this->viewVars['modelo_de_layout'];
		$c_modelo = Inflector::camelize($modelo);
		
		$lista_de_helpers = $helpers; 
		foreach ($lista_de_helpers as $helper => $parametros)
		{
			if (is_string($helper) && strpos($helper,'*') !== false)   //tem que ver se pode mexer assim no índice do foreach, acho que sim
			{
				$helper_real = str_replace('*', $c_modelo, $helper);
				$helpers[$helper_real] = $parametros; //reformula o vetor colocando com o nome verdadeiro e os parametros
				unset($helpers[$helper]); //desseta a chave que tem o asterisco
				$helper = $helper_real;
			}
			
			$res = array_search($helper, $helpers); // tira a string simples se ela existir
			if ($res != false)
			{
				unset($helpers[$res]);
			}
		}
	
		$helpers_carregados =& parent::_loadHelpers($loaded, $helpers, $parent);

		foreach($helpers as $nome_helper => $helper) //primeiro identifica aqueles que tem alias
		{
			if (isset($helper['nome']))
			{
				if (strpos($nome_helper, '.') !== false) 
				{
					list($plugin, $nome_helper) = explode('.', $nome_helper); //tirando o nome do plugin, para poder acessar o helper carregado
				}
				if (isset($helpers_carregados[$nome_helper]))
				{
					$helpers_carregados[$helper['nome']] =& $helpers_carregados[$nome_helper];
					if (isset($loaded[$parent])) //se estamos carregando helpers para helpers, temos também que mudar o nome do helper para o helper filho
					{
						$loaded[$parent]->{$helper['nome']} =& $helpers_carregados[$nome_helper];
					}
				}
			}
		}
		
		return $helpers_carregados;
	}
}

?>