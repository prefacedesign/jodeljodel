<?php
/* cork_cork Test cases generated on: 2010-12-10 11:12:39 : 1291986819*/
App::import('Helper', 'Corktile.CorkCork');

class CorkCorkHelperTestCase extends CakeTestCase {
	function startTest()
	{
		$this->CorkCork = new CorkCorkHelper();
	}

	function teste()
	{

		$html_config = array();
		$options = array(
			'key' => 'mais_um_outro_outro_um_quatro',
			'type' => 'text',
			'title' => 'esse é o titulo',
			'localization' => 'aqui a localização',
			'description' => 'aqui uma breve descrição',
			'id_content' => 1
		);

		$expected = 'Conteúdo do Text <BR>Conteudo do texto Conteudo do texto Conteudo do texto Conteudo do texto Conteudo do texto Conteudo do texto ';

		$result = $this->CorkCork->tile($html_config, $options);

		$this->assertEqual($result,$expected);
	}

}
?>