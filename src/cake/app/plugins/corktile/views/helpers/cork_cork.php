<?php

class CorkCorkHelper extends AppHelper {
	public $helpers = array('Html', 'Form', 'Ajax', 'Js' => 'prototype', 'Burocrata.BuroOfficeBoy',
		'Typographer.*TypeBricklayer' => array(
			'name' => 'Bl'
		)
	);

	function tile ($htmlAttributes = array(), $options = array())
	{
		if (isset($options['key'])) {
			$htmlDefault = array ('class' => array('cork'));
			$BrickLayer = new TypeBricklayerHelper(array());

			$htmlAttributes = $BrickLayer->_mergeAttributes($htmlAttributes, $htmlDefault);
			$corkModel = & ClassRegistry::init('Corktile.CorkCorktile');

			/*
			 *@TODO verificar se retorna null quando não encontra
			 */
			/*
			 * caso não exista a chave é inserido na base do corktile
			 * caso exista, já será recuperado para o $this. será?
			 */
			$currentCork = $corkModel->findByKey($options['key']);
			if ($currentCork == '')
				$currentCork = $corkModel->save(array('CorkCorktile' => $options));

			//@TODO fazer o tratamento do localization padrão

			/*
			 * chamar função getCorkContent do model CorkCorktile.type
			 *
			 */
			$pluginNamelow = $currentCork['CorkCorktile']['type'];
			$pluginName = Inflector::camelize($pluginNamelow);
			$contentModel=& ClassRegistry::init($pluginName.'.'.$pluginName.$pluginName);

			$dataCork = $contentModel->getCorkContent($currentCork['CorkCorktile']['id_content'], $options);

			$View = ClassRegistry::init("View");

			//@TODO: resolver cache, como vai funcionar
			$resultContent = $View->element($pluginNamelow, array(
					'plugin' => $pluginName,
					'type' => array('cork'),
					'options' => $options,
					'data' => $dataCork
				)
			);

			//@TODO: o que vai no options? (pois o options do tile tem outra função)
			$result = $View->element('corktile', array(
					'plugin' => 'corktile',
					'location' => $currentCork['CorkCorktile']['location'],
					'description' => $currentCork['CorkCorktile']['description'],
					'content' => $resultContent,
					'htmlAttributes' => $htmlAttributes,
					'options' => array(),
					'Bl' => $this->Bl
				)
			);

			return $result;
		}
		
	}
    
}


?>
