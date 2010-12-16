<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class CorkCorkHelper extends AppHelper {
	function tile ($html_config = array(), $options = array())
	{
		if (isset($options['key'])) {
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

			$dataCork = $contentModel->getCorkContent($currentCork['CorkCorktile']['id_content'], array("html_config" => $html_config));

			$View = ClassRegistry::init("View");

			//@TODO: ver a respeito do cache (quanto tempo deixar?)
			$resultContent = $View->element($pluginNamelow, array(
					'plugin' => $pluginName,
					'type' => array('cork'),
					'options' => $options,
					'data' => $dataCork
				)
			);

			$result = $View->element('corktile', array(
					'plugin' => 'corktile',
					'location' => $currentCork['CorkCorktile']['location'],
					'description' => $currentCork['CorkCorktile']['description'],
					'content' => $resultContent
				)
			);

			return $result;
		}
		
	}
    
}


?>
