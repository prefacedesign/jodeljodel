<?php
echo $this->Bl->scaixote(array(),array('size' => array('M' => 12)));
	echo $this->Bl->scaixa(array(),array('size' => array('M' => 6)));
		echo $this->Bl->scoluna();
			echo $this->Cork->tile(array(), array(
				'key' => 'contact_info',
				'type' => 'text_cork',
				'title' => 'Informações de contato',
				'location' => $ourLocation,
				'editorsRecommendations' => 
					'Este texto aparece na seção Contato. Deve conter informações básicas para contato, e alguma ou outra recomendação cabível.',
				'options' => array(
					'textile' => true,
					'convertLinks' => false
				)
			));
		echo $this->Bl->ecoluna();
	echo $this->Bl->ecaixa();
echo $this->Bl->ecaixote();
?>