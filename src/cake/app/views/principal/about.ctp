<?php
echo $this->Bl->scaixote(array(),array('size' => array('M' => 12)));
	echo $this->Bl->scaixa(array(),array('size' => array('M' => 5)));
		echo $this->Bl->scoluna();
			echo $this->Cork->tile(array(), array(
				'key' => 'about_dinafon',
				'type' => 'text_cork',
				'title' => 'Texto sobre o Dinafon',
				'location' => $ourLocation,
				'editorsRecommendations' => 
					'Este texto aparece na página sobre o grupo de pesquisa. Ele deve esclarecer'
					.' sobre as atividades do grupo, suas origens e história. O texto deve ter entre 500 e 2000'
					.' caracteres.',
				'options' => array(
					'textile' => true,
					'convertLinks' => false
				)
			));
		echo $this->Bl->ecoluna();
	echo $this->Bl->ecaixa();
	
	echo $this->Bl->scaixa(array(),array('size' => array('M' => 5)));
		echo $this->Bl->scoluna();

			echo $this->Bl->h2(array(),array(),$pageSections['public_page']['subSections']['about']['subSections']['people']['headerCaption']);
			foreach ($people as $k => $personData)
			{
				echo $this->element('pers_person',array('plugin' => 'person', 'type' => array('mini_preview'), 'data' => $personData));
			}
			
			echo $this->Bl->para(array(),array(),
					array(
						$this->Bl->anchor(array(),array('url' => array('plugin' => 'person', 'controller' => 'pers_people', 'action' => 'index')),__('about_dinafon page: Know all people', true))
					)
			);
		echo $this->Bl->ecoluna();
	echo $this->Bl->ecaixa();
echo $this->Bl->ecaixote();
?>