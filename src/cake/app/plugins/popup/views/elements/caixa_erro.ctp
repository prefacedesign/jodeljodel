<?php

	$caixa_links = array();
	$caixa_scripts = array();
	
	// Inclui o arquivo de Javascript com a classe de popup
	$javascript->link('/js/prototype', false);
	$javascript->link('/popup/js/popup', false);
	
	// monta os caixa_links_callbacks de callback
	$caixa_links_callbacks = array();
	$caixa_lista_links = array();
	if(!empty($acoes))
	{
		foreach($acoes as $caixa_acao => $caixa_link)
		{
			$caixa_link_id = uniqid('link_');
			$caixa_links_callbacks[] = $html->link($caixa_link, $this->here, array('id' => $caixa_link_id, 'class' => 'link_button'));
			$caixa_lista_links[] = '"'.$caixa_acao.'":"'.$caixa_link_id.'"';
		}
	}
	
	// imprime o corpo da caixa
	echo $this->Bl->sboxcontainer(array('id' => $id, 'class' => 'caixa_popup caixa_erro'), array());
		echo $this->Bl->sbox(array(), array('size' => array('M' => 7, 'g' => -3)));
			echo $this->Bl->sh2();
				echo $titulo;
			echo $this->Bl->eh2();
			echo $this->Bl->sdiv();
				echo $conteudo;
			echo $this->Bl->ediv();
			echo $this->Bl->sdiv(array('class' => 'callbacks'));
				echo implode('&emsp;', $caixa_links_callbacks);
			echo $this->Bl->ediv();
			echo $this->Bl->floatBreak();
		echo $this->Bl->ebox();
	echo $this->Bl->eboxcontainer();
	
	// imprime o código que cria uma instância da classe
	$caixa_lista_links = '{'.implode(',', $caixa_lista_links).'}';
	echo $javascript->codeBlock("
		new Popup('$id', $caixa_lista_links).addCallback(function(acao){ $callback; });
	");
?>