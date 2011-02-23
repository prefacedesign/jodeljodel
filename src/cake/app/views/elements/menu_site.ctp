<?php

	if(!isset($nivel))
		$nivel = 0;
	switch ($nivel)
	{
		case 0:
			echo $this->Bl->scaixote(array('class' => array('menu_0')),array('size' => array('M' => 6)));
				foreach($pageSections[$ourLocation[0]]['subSections'] as $secao => $dados_secao)
				{
					echo $this->Bl->scaixa(array(),array('size' => array('M' => 2), 'tipo' => 'transparente'));
						//if (/*$dados_secao['active'] &&*/ $dados_secao['display'])
						{
							if (isset($ourLocation[1]) && ($secao == $ourLocation[1]))
								echo $this->Bl->anchor(array('class' => array('selecionado')),array('url' => $dados_secao['url']),$dados_secao['linkCaption'] );
							else
								echo $this->Bl->anchor(array(),array('url' => $dados_secao['url']),$dados_secao['linkCaption'] );
						}
					echo $this->Bl->ecaixa();
				}
			echo $this->Bl->ecaixote();
		break;

		case 1:
			echo $kulepona->barraHorizontal('colorida_branco');
			echo $kulepona->iTag('div', array('class' => array('centralizado','coluna_principal')));
				echo $kulepona->iTag('div', array('class' => array('div_intrapolante')));
					echo $kulepona->tag('h1', array(), array(), $menus_secoes[$onde_estamos[0]]['titulo_cabecalho']);
					if(isset($menus_secoes[$onde_estamos[0]]['sub_secoes']['tipo'])
						&& $menus_secoes[$onde_estamos[0]]['sub_secoes']['tipo'] == 'lateral')
					{
						echo $this->element('menu_site', array('nivel' => 2, 'tipo' => 'lateral'));
					}
				echo $kulepona->fTag('div');
			echo $kulepona->fTag('div');
			echo $kulepona->limpador();

			if (  isset($menus_secoes[$onde_estamos[0]]['sub_secoes'])
			   && !(isset($menus_secoes[$onde_estamos[0]]['sub_secoes']['tipo'])
					&& $menus_secoes[$onde_estamos[0]]['sub_secoes']['tipo'] == 'lateral'))
			{
				echo $this->element('menu_site', array('nivel' => 2, 'tipo' => 'normal'));
			}
		break;

		case 2:
			if ($tipo == 'normal')
			{
				echo $kulepona->barraHorizontal('tracejada_cinza_branco');
				echo $kulepona->iTag('div', array('class' => array('centralizado','coluna_principal')));
					echo $kulepona->iTag('div', array('class' => array('div_intrapolante', 'menu_1')));

						$links_html = array();
						foreach($menus_secoes[$onde_estamos[0]]['sub_secoes'] as $secao => $dados_secao)
						{
							$atributos = array();
							if ($onde_estamos[1] == $secao)
							{
								$atributos = array_merge_recursive($atributos, array('class' => 'selecionado'));
							}
							$links_html[] = $kulepona->link($dados_secao['titulo_link'], $dados_secao['link'], $atributos);
						}
						echo implode($kulepona->espacoM(), $links_html);
					echo $kulepona->fTag('div');
				echo $kulepona->fTag('div');
				echo $kulepona->limpador();
			}
			if ($tipo == 'lateral')
			{
				$links_html = array();
				foreach($menus_secoes[$onde_estamos[0]]['sub_secoes'] as $secao => $dados_secao)
				{
					if (($onde_estamos[1] != $secao) && ($secao != 'tipo'))
					{
						$links_html[] = $kulepona->link($dados_secao['titulo_link'], $dados_secao['link']);
					}
				}

				if (!empty($links_html))
				{
					echo $kulepona->iTag('div', array('class' => array('menu_1_lateral')));
							echo implode($kulepona->espacoM(), $links_html);
					echo $kulepona->fTag('div');
				}
			}
		break;
	}

?>