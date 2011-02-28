<?php
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
}
?>