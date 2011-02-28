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
			$sectionsContext = $pageSections[$ourLocation[0]]['subSections'][$ourLocation[1]];
			
			echo $this->Bl->barraHorizontal(array('class' => array('colorida_branco')));
			echo $this->Bl->sdiv(array('class' => array('centralizado','coluna_principal')));
				echo $this->Bl->sdiv(array('class' => array('div_intrapolante')));
				//@TODO change this next 3 (or 4) lines
					echo $this->Bl->h1(array(),array(), $sectionsContext['headerCaption']);
					if(isset($sectionsContext['dinafonSubSectionsMenuType'])
						&& $sectionsContext['dinafonSubSectionsMenuType'] == 'lateral')
					{
						echo $this->element('menu_site', array('nivel' => 2, 'tipo' => 'lateral'));
					}
				echo $this->Bl->ediv();
			echo $this->Bl->ediv();

			echo $this->Bl->floatBreak();

			if (  isset($sectionsContext['subSections'])
			   && !(isset($sectionsContext['dinafonSubSectionsMenuType'])
					&& $sectionsContext['dinafonSubSectionsMenuType'] == 'lateral'))
			{
				echo $this->element('menu_site', array('nivel' => 2, 'tipo' => 'normal'));
			}
		break;

		case 2:
			if ($tipo == 'normal')
			{
				$sectionsContext = $pageSections[$ourLocation[0]]['subSections'][$ourLocation[1]];
				
				echo $this->Bl->barraHorizontal(array('class' => array('tracejada_cinza_branco')));
				echo $this->Bl->sdiv(array('class' => array('centralizado','coluna_principal')));
					echo $this->Bl->sdiv(array('class' => array('div_intrapolante','menu_1')));
						$links_html = array();
						foreach($sectionsContext['subSections'] as $secao => $dados_secao)
						{
							$atributos = array();
							if ($ourLocation[2] == $secao)
							{
								$atributos = array_merge_recursive($atributos, array('class' => 'selecionado'));
							}
							$links_html[] = $this->Bl->anchor($atributos,array('url' => $dados_secao['url']), $dados_secao['linkCaption']);
						}
						echo implode($this->Bl->espacoM(), $links_html);
					echo $this->Bl->ediv();
				echo $this->Bl->ediv();
				echo $this->Bl->floatBreak();
			}
			if ($tipo == 'lateral')
			{
				$links_html = array();
				foreach($pageSections[$ourLocation[0]]['subSections'] as $secao => $dados_secao)
				{
					if (($ourLocation[2] != $secao) && ($secao != 'tipo'))
					{
						$links_html[] = $this->Bl->anchor(array(),array('url' => $dados_secao['url']), $dados_secao['linkCaption']);
					}
				}

				if (!empty($links_html))
				{
					echo $this->Bl->sdiv(array('class' => array('menu_1_lateral')));
							echo implode($this->Bl->espacoM(), $links_html);
					echo $this->Bl->ediv();
				}
			}
		break;
	}

?>