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
			'key' => 'outro',
			'type' => 'text',
			'title' => 'esse é o titulo',
			'location' => 'aqui a localização',
			'description' => 'aqui uma breve descrição',
			'id_content' => 1
		);


		$result = $this->CorkCork->tile($html_config, $options);
		echo $result;
	}

}
?>