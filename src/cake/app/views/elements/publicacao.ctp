<?php

	switch ($tipo)
	{
		case 'preview':
			echo $this->Bl->span(array('class' => 'texto_pequeno'), array(),
				br_strftime('%B de %Y', strtotime($dados['data']))
				. ', ' .$dados['periodico']
			);
			echo $this->Bl->brDry();
			echo $this->Bl->span(array('class' => 'texto_pequeno'), array(),
				implode(', ', $dados['autores'])
			);

			echo $this->Bl->h4(array(),array(),$this->Bl->anchor(array('url' => array('controller' => 'publicacoes', 'action' => 'ver', $dados['id'])),array(),$dados['titulo']));

			$explodido = explode(' ', $dados['resumo'][0], 40);
			if (isset($explodido[39]))
				unset($explodido[39]);

			$resuminho = implode(' ', $explodido) . '...';

			echo $this->Bl->para(
				array(),
				array(),
				array($resuminho)
			);

			echo $this->Bl->para(
				array('class' => 'texto_pequeno'),
				array(),
				array('Palavras-chave: ' . implode(', ', $dados['palavras_chave']))
			);
		break;

		case 'principal_sem_ficha_tecnica':
			echo $this->Bl->h2(array(),array(),$dados['titulo']);
			echo $this->Bl->para(
				array(),
				array(),
				array($dados['resumo'])
			);
	

			$links = '';
			if (isset($dados['arquivo']))
			{
				$links .= $this->Bl->anchor(array('url' => '/arquivos/' . $dados['arquivo'] ),array(),'Artigo para download')
						. $this->Bl->brDry();

			}
			echo $this->Bl->para(
				array(),
				array(),
				array($links)
			);
		break;

		case 'ficha_tecnica':
			echo $this->Bl->h4(array(),array(),'Autores');
			echo $this->Bl->para(
				array(),
				array(),
				implode(', ', $dados['autores'])
			);
			echo $this->Bl->h4(array(),array(),'Publicação');

			echo $this->Bl->para(
				array(),
				array(),
				array(
					br_strftime('%B de %Y', strtotime($dados['data']))
					. ', ' . $dados['periodico']
					. $kulepona->tag('br')
					. $dados['referencia']
				)
			);

			echo $this->Bl->h4(array(),array(),'Palavras-chave');
			echo $this->Bl->para(
				array(),
				array(),
				array(
					implode(', ', $dados['palavras_chave'])
				)
			);
		break;

		case 'principal':
			echo $this->Bl->scaixote(array(),array('size' => array('M' => 10)));
				echo $this->Bl->scaixa(array(),array('size' => array('M' => 6)));
					echo $this->Bl->scoluna();
						echo $this->element('publicacao', array('tipo' => 'principal_sem_ficha_tecnica', 'dados' => $dados));
					echo $this->Bl->ecoluna();
				echo $this->Bl->ecaixa();
				echo $this->Bl->scaixa(array(),array('size' => array('M' => 4)));
					echo $this->Bl->scoluna();
						echo $this->element('publicacao', array('tipo' => 'ficha_tecnica', 'dados' => $dados));
					echo $this->Bl->ecoluna();
				echo $this->Bl->ecaixa();
			echo $this->Bl->ecaixote();
		break;
	}

?>