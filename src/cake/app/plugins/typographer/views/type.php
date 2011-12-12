<?php
//cria os aliases para os helpers -- e trata os helpers com o coringa '*'
//@todo documentate this in English
class TypeView extends View
{
/**
 * 
 * 
 * @access public
 */
	function &_loadHelpers(&$loaded, $helpers, $parent = null) 
	{
		$layout_scheme = $this->getVar('layout_scheme');
		if (empty($layout_scheme))
		{
			trigger_error('TypeView::_loadHelpers() - `layout_scheme` was not send to view by controller.');
			return parent::_loadHelpers($loaded, $helpers, $parent);
		}
		
		$c_layout_scheme = Inflector::camelize($layout_scheme);
		
		$helpers_list = $helpers;
		foreach ($helpers_list as $helper => $params)
		{
			if (is_string($helper) && strpos($helper,'*') !== false)   //tem que ver se pode mexer assim no �ndice do foreach, acho que sim
			{
				$real_helper = str_replace('*', $c_layout_scheme, $helper);
				$helpers[$real_helper] = $params; //reformula o vetor colocando com o nome verdadeiro e os parametros
				unset($helpers[$helper]); //desseta a chave que tem o asterisco
				$helper = $real_helper;
			}
			else {
				unset($helpers[$helper]);
				$helpers[$helper] = $params;
			}
			
			$res = array_search($helper, $helpers); // tira a string simples se ela existir
			if ($res != false)
			{
				unset($helpers[$res]);
			}
		}
	
		$loaded_helpers =& parent::_loadHelpers($loaded, $helpers, $parent);

		foreach($helpers as $helper_name => $helper) //primeiro identifica aqueles que tem alias
		{
			if (isset($helper['name']))
			{
				if (strpos($helper_name, '.') !== false) 
				{
					list($plugin, $helper_name) = explode('.', $helper_name); //tirando o nome do plugin, para poder acessar o helper carregado
				}
				if (isset($loaded_helpers[$helper_name]))
				{
					$loaded_helpers[$helper['name']] =& $loaded_helpers[$helper_name];
					if (isset($loaded[$parent])) //se estamos carregando helpers para helpers, temos tamb�m que mudar o nome do helper para o helper filho
					{
						$loaded[$parent]->{$helper['name']} =& $loaded_helpers[$helper_name];
					}
				}
			}
		}
		
		return $loaded_helpers;
	}

/**
 * Overwrites the View::element() function so we can deal with the $type parameter
 * 
 * @access public
 * @return string The result of View::element()
 */
	function element($name, $params = array(), $loadHelpers = false)
	{
		$typeBkp = $this->getVar('type');;
		if (isset($params['type']))
			$this->viewVars['type'] = $params['type'];
		
		$out = parent::element($name, $params, $loadHelpers);
		
		$this->viewVars['type'] = $typeBkp;		
		return $out;
	}

/**
 * This method overwrites the View::_paths() method so it can include the dashboard plugin path as candidate
 * 
 * @access public
 * @return array Array of possible paths from View::_paths() merged with dashboard plugin path
 */	
	function _paths($plugin = null, $cached = true)
	{
		$paths = parent::_paths($plugin, $cached);
		array_push($paths, App::pluginPath('backstage') . 'views' . DS);
		return $paths;
	}
}
