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

class CorkCorktilesController extends CorktileAppController {

	var $name = 'CorkCorktiles';
	var $uses = array('Corktile.CorkCorktile');
	
	/** Used to make tests. Not the cake standard way.
	 *
	 */
	function cork_test()
	{
	}
	
	/** 
	 * Form plugged into the backstage layout. That serves to edit 
	 * any Corktile.
	 *  
	 */

	function edit($key)
	{
		$this->data = $this->CorkCorktile->getFullData($key);
		
		$this->set('contentPlugin', $this->data['ModuleInfo']['plugin']);
        $this->set('modelName', $this->data['ModuleInfo']['model']);
        $this->set('fullModelName', Inflector::camelize($this->data['ModuleInfo']['plugin']) . '.' . $this->data['ModuleInfo']['model']);
	}
	
	
	/** 
	 * To create a empty translation register. This action calls
	 * a createEmptytranlation method of TradTradutore Behavior
	 *
	 * @access public
	 * @param string $moduleName Module name, configured on bootstrap.php
	 * @param string $id The id of the row to set a new status to.
	 */
	
	function create_empty_translation($key)
	{
		$this->data = $this->CorkCorktile->getFullData($key);
		$fullModelName = Inflector::camelize($this->data['ModuleInfo']['plugin']) . '.' . $this->data['ModuleInfo']['model'];
        $Model =& ClassRegistry::init($fullModelName);
		
		
		if ($Model->createEmptyTranslation($this->data['CorkCorktile']['content_id'], $this->params['language']))
			$this->redirect('edit/'.$key);
		
	}
}
?>