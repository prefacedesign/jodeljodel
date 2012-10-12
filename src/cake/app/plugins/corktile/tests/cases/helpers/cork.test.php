<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

/* cork_cork Test cases generated on: 2010-12-10 11:12:39 : 1291986819*/
App::import('Helper', 'Corktile.Cork');

class CorkHelperTestCase extends CakeTestCase {
	function startTest()
	{
		$this->Cork = new CorkHelper();
	}

	function teste()
	{

		$htmlConfig = array();
		$options = array(
			'key' => 'outro',
			'type' => 'text',
			'title' => 'esse é o titulo',
			'location' => 'aqui a localização',
			'description' => 'aqui uma breve descrição',
			'id_content' => 1
		);


		$result = $this->Cork->tile($htmlConfig, $options);
		echo $result;
	}

}
?>