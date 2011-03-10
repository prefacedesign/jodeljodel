<?php
	echo $this->Bl->scaixote(array(),array('size' => array('M' => 7)));
		echo $this->Bl->scaixa(array(),array('size' => array('M' => 7)));
			echo $this->Bl->scoluna();
				
				echo $this->Bl->h2Dry($pageSections['public_page']['subSections']['events']['humanName']);
				echo $this->element('eve_event', array('plugin' => 'event', 'type' => array('preview'), 'data' => $event));
				
				//array('plugin' => 'event', 'controller' => 'eve_events', 'action' => 'index')
				
				echo $this->Bl->floatBreak();

				echo $this->Bl->sdiv(array('class' => 'noticias_pagina_principal'));
					if (isset($news))
					{
						echo $this->Bl->h2Dry($pageSections['public_page']['subSections']['news']['humanName']);
						
						if (isset($news[0]))
						{
							echo $this->element('news_new', array('plugin' => 'new', 'type' => array('preview'), 'data' => $news[0]));
							unset($news[0]);
						}
						
						foreach($news as $newsData)
						{
							echo $this->element('news_new', array('plugin' => 'new', 'type' => array('linha_link'), 'data' => $newsData));
						}
						echo $this->Bl->brDry();
						echo $this->Bl->span(array(), array('escape' => true), $this->Bl->anchor(array(),array('url' => array('plugin' => 'new', 'controller' => 'news_new', 'action' => 'index')),__('public_page: See more news', true)));
						echo $this->Bl->brDry();
						echo $this->Bl->brDry();
					}
				echo $this->Bl->ediv();

				echo $this->Bl->sdiv(array('class' => 'publicacoes_pagina_principal'));
					if (isset($papers))
					{
						echo $this->Bl->h2Dry($pageSections['public_page']['subSections']['papers']['humanName']);
						
						foreach($papers as $paperData)
						{
							echo $this->element('pap_paper', array('plugin' => 'paper', 'type' => array('preview'), 'data' => $paperData));
						}
						
						echo $this->Bl->span(array(), array('escape' => true), $this->Bl->anchor(array(),array('url' => array('plugin' => 'paper', 'controller' => 'pap_paper', 'action' => 'index')), __('public_page: More papers from Dinafon',true)));
						echo $this->Bl->brDry();
						echo $this->Bl->brDry();
					}
				echo $this->Bl->ediv();
			echo $this->Bl->ecoluna();
		echo $this->Bl->ecaixa();
	echo $this->Bl->ecaixote();

	echo $this->Bl->scaixote(array(),array('size' => array('M' => 5)));
		echo $this->Bl->scaixa(array(),array('size' => array('M' => 5)));
			echo $this->Bl->scoluna();
				
				echo $this->Bl->h2Dry($pageSections['public_page']['subSections']['about']['subSections']['about_dinafon']['humanName']);
				
				echo $this->Cork->tile(array(), array(
					'key' => 'short about_dinafon',
					'type' => 'text_cork',
					'title' => 'Texto sobre o Dinafon da página inicial',
					'location' => $ourLocation,
					'editorsRecommendations' => 
						'Este texto aparece na página inicial. Deve resumir em poucas palavras o que é o Dinafon. '
						.'O texto deve ter entre 150 e 400 caracteres.',
					'options' => array(
						'textile' => true,
						'convertLinks' => false
					)
				));
				
				echo $this->Bl->span(array(), array('escape' => true), $this->Bl->anchor(array(),array('url' => array('controller' => 'principal', 'action' => 'about')), __('public_page: More about Dinafon', true)));
				echo $this->Bl->div(array('id' => 'atrator_aleatorio'));
			echo $this->Bl->ecoluna();
		echo $this->Bl->ecaixa();
	echo $this->Bl->ecaixote();
?>