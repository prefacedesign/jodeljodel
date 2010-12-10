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
			$return = $corkModel->findByKey($options['key']);
			if ($return == '')
				$return = $corkModel->save(array('CorkCorktile' => $options));

			//@TODO fazer o tratamento do localization padrão

			/*
			 * chamar função getCorkContent do model CorkCorktile.type
			 *
			 */
			$pluginName = Inflector::camelize($return['CorkCorktile']['type']);
			$contentModel=& ClassRegistry::init($pluginName.'.'.$pluginName.$pluginName);
			return $contentModel->getCorkContent($return['CorkCorktile']['id_content'], array("html_config" => $html_config));
		}
		
	}
    
}


?>
