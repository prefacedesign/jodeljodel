<?php
/* cork_corktile Test cases generated on: 2010-12-09 16:12:36 : 1291919256*/
App::import('Model', 'Corktile.CorkCorktile');

class CorkCorktileTestCase extends CakeTestCase {
	    var $fixtures = array(
        'plugin.corktile.cork_corktile',
        'plugin.text.text_text'
    );

	function CorktileTestCase()
	{
		$this->CorkCorktile =& ClassRegistry::init('CorkCorktile');
		
		$html_config = array();
		$options = array(
			'key' => 'outro_texto',
			'type' => 'text',
			'title' => 'esse é o titulo',
			'localization' => 'aqui a localização',
			'description' => 'aqui uma breve descrição',
			'id_content' => 1
		);

		debug($this->CorkCorktile->tile($html_config, $options));
		
	}


}
?>