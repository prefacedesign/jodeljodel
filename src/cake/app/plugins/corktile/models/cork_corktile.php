<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Carregando o arquivo com as configurações padrões
 */
Configure::load('CorkCorktile.config');
Configure::read('CorkCorktile.type');

class CorkCorktile extends CorktileAppModel
{
	var $name = 'CorkCorktile';

	function tile ($html_config = array(), $options = array())
	{
		if (isset($options['key']))
			/*
			 *@TODO verificar se retorna null quando não encontra
			 */
			/*
			 * caso não exista a chave é inserido na base do corktile
			 * caso exista, já será recuperado para o $this. será?
			 */
			if ($this->findByKey($options['key']) == null)
				$this->save(array('CorkCorktile' => $options));


			//@TODO fazer o tratamento do localization padrão

			/*
			 * chamar função getCorkContent do model CorkCorktile.type - ver qual o nome correto do model
			 *
			 */
			$pluginName = Inflector::camelize($this['CorkCorktile']['type']);
			$contentModel=& ClassRegistry::init($pluginName.'.'.$pluginName.$pluginName);
			return $contentModel->getCorkContent($this['CorkCorktile']['id_content'], array("html_config" => $html_config));
	}
}

?>
