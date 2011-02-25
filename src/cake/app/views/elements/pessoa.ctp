<?php

	switch ($tipo)
	{
		case 'mini_preview':

			echo $this->Bl->h4(array(),array(),$this->Bl->anchor(array(),array('url' => array('controller' => 'pessoas', 'action' => 'ver', $dados['id'])),$dados['nome']));

			echo $this->Bl->para(
						array(),
						array(),
						array(
						'Área de pesquisa:&ensp;'
						. $this->Bl->span(array ('class' => 'italico'), array(), $dados['area_pesquisa'])
						)
			);
			
		break;

		case 'preview':

			echo $this->Bl->h4(array(),array(),$this->Bl->anchor(array(),array('url' => array('controller' => 'pessoas', 'action' => 'ver', $dados['id'])),$dados['nome']));

			$explodido = explode(' ', $dados['colaboracao'], 36);
			if (isset($explodido[35]))
				unset($explodido[35]);
			$colaboracao_dinafon = implode(' ', $explodido) . '...';

			/*
			echo $kulepona->para(
				array(
					$kulepona->tag('span', array ('class' => 'italico'), array(), $dados['titulos'])
				)
			);*/


			echo $this->Bl->para(
				array(),
				array(),
				array(
				'Área de pesquisa:&ensp;'
				. $this->Bl->span(array ('class' => 'italico'), array(), $dados['area_pesquisa'])
				)
			);

			echo $this->Bl->para(
				array(),
				array(),
				array(
				'Colaboração com o Dinafon:&ensp;'
				. $this->Bl->span(array ('class' => 'italico'), array(), $colaboracao_dinafon)
				)
			);

		break;

		case 'principal':
			echo $this->Bl->h2(array(),array(),$dados['nome']);

			//echo $kulepona->para($dados['titulos']);

			echo $this->Bl->h4(array(),array(),'Área de pesquisa');

			echo $this->Bl->para(
				array(),
				array(),
				array($dados['area_pesquisa'])
			);
			
			echo $this->Bl->para(
				array(),
				array(),
				array($this->Bl->anchor(array('href' => $dados['link_lattes']),array(),'Curriculum Lattes'))
			);

			echo $bl->barraHorizontal(array('class' => array('cinza_branco')));

			echo $this->Bl->h4(array(),array(),'Colaboração com o Dinafon');

			echo $this->Bl->para(
				array(),
				array(),
				array($dados['colaboracao'])
			);

			echo $this->Bl->h4(array(),array(),'Perfil');

			echo $this->Bl->para(
				array(),
				array(),
				array($dados['perfil'])
			);
		break;

		default:
			trigger_error('Não existe este tipo de elemento notícia: "' . $tipo .'"');
	}

?>