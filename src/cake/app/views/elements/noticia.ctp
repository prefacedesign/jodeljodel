<?php

	switch ($tipo)
	{
		case 'preview':
			echo $this->Bl->span(array('class' => 'texto_pequeno'),array(), br_strftime('%d de %B', strtotime($dados['data'])));

			echo $this->Bl->h4(array(),array(),$this->Bl->anchor(array(),array('url' => array('controller' => 'noticias', 'action' => 'ver', $dados['id'])),$dados['titulo']) );

			$explodido = explode(' ', $dados['texto'][0], 30);
			if (isset($explodido[29]))
				unset($explodido[29]);

			$resuminho = implode(' ', $explodido) . '...';


			echo $this->Bl->para(
						array(),
						array(),
						array($resuminho)
			);
		break;

		case 'principal':
			echo $this->Bl->h2(array(),array(),$dados['titulo']);
			echo $this->Bl->span(array('class' => 'texto_pequeno'),array(),br_strftime('%d de %B de %Y', strtotime($dados['data']))
				. ', por ' .$dados['autor']);


			echo $this->Bl->brDry();
			echo $this->Bl->brDry();

			echo $this->Bl->para(
						array(),
						array(),
						array($dados['texto'])
			);

		break;

		case 'linha_link':
			echo $this->Bl->span(array('class' => array('texto_pequeno', 'caixinha', 'w_4g')), array(), br_strftime('%d/%m', strtotime($dados['data'])) );

			echo $this->Bl->span(array('class' => array('caixinha_2', 'w_3M_-3g_-1m')),
					array('escape' => true),
					$this->Bl->anchor(
							array(),
							array(
								'url' => array(
									'controller' => 'noticias',
									'action' => 'ver',
									$dados['id']
								)
							),
							$dados['titulo']
					)


			);

			echo $this->Bl->floatBreak();
		break;
		default:
			trigger_error('Não existe este tipo de elemento notícia: "' . $tipo .'"');
	}

?>

